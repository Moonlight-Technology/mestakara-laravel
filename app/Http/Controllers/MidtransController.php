<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;
use Modules\Booking\Models\Booking as ModelsBooking;

class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
    {
        $notif = $request->all();

        $transaction = $notif['transaction_status'] ?? null;
        $orderId = $notif['order_id'] ?? null;
        $fraud = $notif['fraud_status'] ?? null;

        // Find booking by order_id
        $booking = ModelsBooking::where('code',$orderId)->first();

        if (!$booking) {
            Log::warning('Booking not found: ' . $orderId);
            abort(404);
        }

        // Update booking status based on transaction status
        switch ($transaction) {
            case 'capture':
                $booking->status = $fraud == 'challenge' ? $booking::ON_HOLD : $booking::PAID;
                break;
            case 'settlement':
                $booking->status    = $booking::PAID;
                $booking->paid      = $booking->pay_now;
                break;
            case 'pending':
                $booking->status = $booking::PENDING;
                break;
            case 'deny':
            case 'expire':
            case 'cancel':
                $booking->status = $booking::CANCELLED;
                break;
        }

        $booking->save();

        return redirect($booking->getDetailUrl())->with("success", __("Your payment has been processed successfully"));
    }
}
