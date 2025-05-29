<?php
namespace Modules\Report\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Booking\Emails\NewBookingEmail;
use Modules\Booking\Models\Booking;
use Modules\Location\Models\Location;


class StatisticController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
{
    $f = strtotime('monday this week');
    $status = config('booking.statuses');

    // Fetch all locations
    $locations = Location::all();

    $data = [
        'earning_chart_data'  => Booking::getStatisticChartData($f, time(), $status)['chart'],
        'earning_detail_data' => Booking::getStatisticChartData($f, time(), $status)['detail'],
        'locations'           => $locations, // Pass locations to the view
    ];

    return view('Report::admin.statistic.index', $data);
}

// public function reloadChart(Request $request)
// {
//     $from = $request->input('from');
//     $to = $request->input('to');
//     $status = config('booking.statuses');
//     $customer_id = false;
//     $vendor_id = false;
//     $location_id = $request->input('location_id'); // Get location filter
//     $hotel_id = $request->input('hotel_id'); // Get hotel filter

//     $user_type = $request->input('user_type');
//     if ($user_type == 'customer') {
//         $customer_id = $request->input('user_id');
//     }
//     if ($user_type == 'vendor') {
//         $vendor_id = $request->input('user_id');
//     }

//     return $this->sendSuccess([
//         'chart_data'  => Booking::getStatisticChartData(strtotime($from), strtotime($to), $status, $customer_id, $vendor_id, $location_id, $hotel_id)['chart'],
//         'detail_data' => Booking::getStatisticChartData(strtotime($from), strtotime($to), $status, $customer_id, $vendor_id, $location_id, $hotel_id)['detail']
//     ]);
// }

public function reloadChart(Request $request)
{
    $from = $request->input('from');
    $to = $request->input('to');
    $status = config('booking.statuses');
    $customer_id = false;
    $vendor_id = false;
    $location_id = $request->input('location_id'); // Get location filter
    $hotel_id = $request->input('hotel_id'); // Get hotel filter

    $user_type = $request->input('user_type');
    if ($user_type == 'customer') {
        $customer_id = $request->input('user_id');
    }
    if ($user_type == 'vendor') {
        $vendor_id = $request->input('user_id');
    }

    // Fetch chart and detail data with the additional hotel filter
    $chartAndDetailData = Booking::getStatisticChartData(
        strtotime($from),
        strtotime($to),
        $status,
        $customer_id,
        $vendor_id,
        $location_id,
        $hotel_id // Pass hotel_id for filtering
    );

    // Ensure both 'chart' and 'detail' keys exist in the response
    $chartData = $chartAndDetailData['chart'] ?? [];
    $detailData = $chartAndDetailData['detail'] ?? [];

    return $this->sendSuccess([
        'chart_data'  => $chartData,
        'detail_data' => $detailData
    ]);
}


public function getHotelsByLocation($location_id)
{
    $hotels = \DB::table('bravo_hotels')
        ->where('location_id', $location_id)
        ->where('status', 'publish') // Optional: Only include published hotels
        ->select('id', 'title')
        ->get();

    return response()->json(['hotels' => $hotels]);
}

}
