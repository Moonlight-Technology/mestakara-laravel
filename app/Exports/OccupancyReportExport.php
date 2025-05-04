<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TiketComReservationController extends Controller
{
    public function handlePushReservation(Request $request)
    {
        // Authentication (Basic Auth)
        $username = $request->header('php-auth-user');
        $password = $request->header('php-auth-pw');

        $expectedUsername = env('TIKETCOM_PUSH_USERNAME');
        $expectedPassword = env('TIKETCOM_PUSH_PASSWORD');

        if ($username !== $expectedUsername || $password !== $expectedPassword) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Log the incoming data for debugging
        Log::info('Reservation Data Received:', $request->all());

        // Validate the request format
        $validatedData = $request->validate([
            'reservation_id' => 'required|string',
            'hotel_code' => 'required|string',
            'room_code' => 'required|string',
            'guest_name' => 'required|string',
            'check_in' => 'required|date',
            'check_out' => 'required|date',
        ]);

        // Process the reservation data (save to DB, notify team, etc.)
        // Example: Save to database
        // Reservation::create($validatedData);

        // Return success response
        return response()->json(['message' => 'Reservation processed successfully.'], 200);
    }
}
