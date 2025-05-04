<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class TiketComService
{
    protected $baseUrl;
    protected $username;
    protected $password;

    public function __construct()
    {
        $this->baseUrl = env('TIKETCOM_API_URL');
        $this->username = env('TIKETCOM_USERNAME');
        $this->password = env('TIKETCOM_PASSWORD');
    }

    public function fetchHotelDetails($hotelId)
{
    $payload = [
        'OTA_HotelProductRQ' => [
            '_Version' => '2.0',
            '_EchoToken' => uniqid(),
            '_TimeStamp' => now()->toIso8601String(),
            '_POS' => [
                'Source' => [
                    'RequestorID' => [
                        '_ID' => env('TIKETCOM_REQUESTOR_ID'),
                        '_Type' => '2', // Test with '1' or '4' if this fails
                    ],
                ],
            ],
            'HotelProducts' => [
                'HotelProduct' => [
                    [
                        '_HotelCode' => $hotelId,
                    ],
                ],
            ],
        ],
    ];

    // Log payload for debugging
    Log::info('Tiket.com API Request Payload:', ['payload' => $payload]);

    $response = Http::withHeaders([
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ])->withBasicAuth($this->username, $this->password)
        ->post("{$this->baseUrl}/tix-hotel-channel-manager/tix-connect/v2/hotel-products", $payload);

    // Log response for debugging
    Log::info('Tiket.com API Response:', $response->json());

    if ($response->successful()) {
        return $response->json();
    }

    throw new \Exception("Error fetching hotel details: " . $response->body());
}






}
