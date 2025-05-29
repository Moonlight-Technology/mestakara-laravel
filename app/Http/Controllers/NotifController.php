<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;
use Modules\Booking\Models\Booking;

class NotifController extends Controller
{
    public function notificationHandler(Request $request)
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = true; // Ubah ke true jika di production
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Buat instance Midtrans notification
        $notification = new Notification();

        $transactionStatus = $notification->transaction_status;
        $paymentType = $notification->payment_type;
        $orderId = $notification->order_id;
        $fraudStatus = $notification->fraud_status;

        // Cari booking berdasarkan kode yang dikirim oleh Midtrans
        $booking = Booking::where('code', $orderId)->first();

        if ($booking) {
            if ($transactionStatus == 'capture') {
                if ($paymentType == 'credit_card') {
                    if ($fraudStatus == 'challenge') {
                        // Transaksi ditandai sebagai "challenge" oleh Midtrans
                        $booking->status = 'pending';
                    } else {
                        // Transaksi berhasil
                        $booking->status = 'paid';
                    }
                }
            } elseif ($transactionStatus == 'settlement') {
                // Transaksi berhasil diselesaikan
                $booking->status = 'paid';
            } elseif ($transactionStatus == 'pending') {
                // Pembayaran tertunda
                $booking->status = 'pending';
            } elseif ($transactionStatus == 'deny') {
                // Pembayaran ditolak
                $booking->status = 'failed';
            } elseif ($transactionStatus == 'expire') {
                // Pembayaran kedaluwarsa
                $booking->status = 'expired';
            } elseif ($transactionStatus == 'cancel') {
                // Pembayaran dibatalkan
                $booking->status = 'canceled';
            }

            // Simpan perubahan status
            $booking->save();
        }

        return redirect($booking->getDetailUrl())->with("success", __("You payment has been processed successfully"));
    }
}