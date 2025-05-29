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
    foreach ($rooms as $room) {
        $itemDetails[] = [
            'id' => $room->room_id,
            'name' => $room->room->title,
            'quantity' => $room->number, // Using room quantity as requested
            'price' => (float)$room->price,
        ];
    }

    // Set parameters for the Midtrans transaction
    $params = [
        'transaction_details' => [
            'order_id' => $booking->code,
            'gross_amount' => (float)$booking->pay_now,
        ],
        'customer_details' => [
            'first_name' => $booking->first_name,
            'last_name'  => $booking->last_name,
            'email'      => $booking->email,
            'phone'      => $booking->phone,
        ],
        'item_details' => $itemDetails, // Set item details here
        'callbacks' => [
            'finish' => url('/midtrans/notificationHandler'), // URL finish for localhost or domain
        ],
    ];

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
