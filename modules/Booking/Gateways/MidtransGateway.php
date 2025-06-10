<?php

namespace Modules\Booking\Gateways;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\Payment;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Mockery\Exception;

class MidtransGateway extends BaseGateway
{
    public $name = 'Midtrans Payment';
    public $is_offline = false;
    protected $id = 'midtrans';
    protected $gateway;

    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.serverKey');
        Config::$clientKey = config('midtrans.clientKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized', true);
        Config::$is3ds = config('midtrans.is3ds', true);
    }

    public function process(Request $request, $booking, $service)
    {
        $service->beforePaymentProcess($booking, $this);
    
        if (in_array($booking->status, [$booking::PAID, $booking::COMPLETED, $booking::CANCELLED])) {
            throw new Exception(__("Booking status does not need to be paid"));
        }
        if (!$booking->pay_now) {
            throw new Exception(__("Booking total is zero. Cannot process payment gateway!"));
        }
    
        // Get rooms associated with the booking
        $rooms = \Modules\Hotel\Models\HotelRoomBooking::getByBookingId($booking->id);
    
        // Prepare item details with room quantity and price
        $itemDetails = [];
        $totalAmount = 0;
        $list_all_fee = [];

        // Mendapatkan buyer fees dari database jika ada
        if (!empty($booking->buyer_fees)) {
            $buyer_fees = json_decode($booking->buyer_fees, true);
            $list_all_fee = $buyer_fees;
        }

        // Menambahkan vendor service fee jika ada
        if (!empty($booking->vendor_service_fee)) {
            $vendor_service_fee = json_decode($booking->vendor_service_fee, true);
            $list_all_fee = array_merge($list_all_fee, $vendor_service_fee);
        }

        // Menghitung total harga dari item (misalnya kamar)
        foreach ($rooms as $room) {
            $itemDetails[] = [
                'id' => $room->room_id,
                'name' => $room->room->title,
                'quantity' => $room->number, // Jumlah kamar
                'price' => (float)$room->price, // Harga kamar
            ];

            // Menghitung total harga dari semua item (kamar)
            $totalAmount += (float)$room->price * $room->number;
        }

        // Loop untuk menghitung fee (pajak, admin fee, dll.)
        if (!empty($list_all_fee)) {
            foreach ($list_all_fee as $item) {
                $fee_price = $item['price'];

                // Jika unit fee dalam persen, hitung berdasarkan total_before_fees
                if (!empty($item['unit']) && $item['unit'] == "percent") {
                    $fee_price = ($booking->total_before_fees / 100) * $item['price'];
                }

                // Menambahkan fee item ke list itemDetails
                $itemDetails[] = [
                    'id' => $item['name'],  // ID fee (misalnya tax, admin_fee)
                    'name' => $item['name'] ?? $item['name'],  // Nama fee (dalam bahasa lokal)
                    'quantity' => 1,  // Quantity = 1 untuk setiap fee
                    'price' => number_format($fee_price, 0, '', ''),  // Harga fee yang dihitung
                ];
            }
        }

        // Menghitung voucher jika ada
        $voucher = $booking->coupon_amount;  // Nilai voucher

        // Menambahkan voucher ke itemDetails
        $itemDetails[] = [
            'id' => 'voucher',
            'name' => 'Voucher',
            'quantity' => 1,  // Quantity = 1 untuk voucher
            'price' => -$voucher,  // Voucher mengurangi harga
        ];

        // Total amount setelah pajak, biaya admin, dan voucher
        $totalAmount += array_sum(array_column($itemDetails, 'price')); // Menjumlahkan semua item price

        // Set parameter untuk transaksi Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $booking->code,  // Kode booking sebagai order_id
                'gross_amount' => number_format($totalAmount, 0, '', ''),  // Total harga yang sudah dihitung
            ],
            'customer_details' => [
                'first_name' => $booking->first_name,
                'last_name'  => $booking->last_name,
                'email'      => $booking->email,
                'phone'      => $booking->phone,
            ],
            'item_details' => $itemDetails,  // Menambahkan semua item detail
            'callbacks' => [
                'finish' => url('/midtrans/notificationHandler'),  // URL untuk notifikasi
            ],
        ];
        Log::info($params);
    
        // Get Midtrans Snap token
        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to generate payment token'], 500);
        }
    
        $payment = new Payment();
        $payment->booking_id = $booking->id;
        $payment->payment_gateway = $this->id;
        $payment->status = 'draft';
        $payment->save();
    
        $booking->status = $booking::UNPAID;
        $booking->payment_id = $payment->id;
        $booking->snap_midtrans = $snapToken;
        $booking->save();
    
        return redirect($booking->getDetailUrl())->with("success", __("Your payment has been processed successfully"));
    }


    public function processNotification(Request $request)
    {
        $notif = new Notification();
        $transaction = $notif->transaction_status;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        $booking = Booking::where('code', $orderId)->first();

        if (!$booking) {
            Log::warning('Booking not found: ' . $orderId);
            return;
        }

        if ($transaction == 'capture') {
            if ($fraud == 'challenge') {
                $booking->status = $booking::ON_HOLD;
            } else {
                $booking->status = $booking::PAID;
            }
        } elseif ($transaction == 'settlement') {
            $booking->status = $booking::PAID;
        } elseif ($transaction == 'pending') {
            $booking->status = $booking::PENDING;
        } elseif ($transaction == 'deny' || $transaction == 'expire' || $transaction == 'cancel') {
            $booking->status = $booking::CANCELLED;
        }

        $booking->save();

        $payment = $booking->payment;
        if ($payment) {
            $payment->status = $booking->status == $booking::PAID ? 'completed' : 'failed';
            $payment->logs = \GuzzleHttp\json_encode($notif->getData());
            $payment->save();
        }
    }

    public function getOptionsConfigs()
    {
        return [
            [
                'type'  => 'checkbox',
                'id'    => 'enable',
                'label' => __('Enable Midtrans Payment?')
            ],
            [
                'type'  => 'input',
                'id'    => 'name',
                'label' => __('Custom Name'),
                'std'   => __("Midtrans Payment"),
                'multi_lang' => "1"
            ]
        ];
    }
}
