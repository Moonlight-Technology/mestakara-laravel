<?php
namespace Modules\Report\Admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Booking\Emails\NewBookingEmail;
use Modules\Booking\Events\BookingUpdatedEvent;
use Modules\Booking\Models\Booking;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BookingsExport;
use Carbon\Carbon;

class BookingController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->setActiveMenu(route('report.admin.booking'));
    }

    public function index(Request $request)
    {
        $this->checkPermission('booking_view');

        $query = Booking::where('status', '!=', 'draft');

        // Filter berdasarkan pencarian teks
        if (!empty($request->s)) {
            if( is_numeric($request->s) ){
                $query->Where('id', '=', $request->s);
            }else{
                $query->where(function ($query) use ($request) {
                    $query->where('first_name', 'like', '%' . $request->s . '%')
                        ->orWhere('last_name', 'like', '%' . $request->s . '%')
                        ->orWhere('email', 'like', '%' . $request->s . '%')
                        ->orWhere('phone', 'like', '%' . $request->s . '%')
                        ->orWhere('address', 'like', '%' . $request->s . '%')
                        ->orWhere('address2', 'like', '%' . $request->s . '%');
                });
            }
        }

        // Filter vendor
        if ($this->hasPermission('booking_manage_others')) {
            if (!empty($request->vendor_id)) {
                $query->where('vendor_id', $request->vendor_id);
            }
        } else {
            $query->where('vendor_id', Auth::id());
        }

        // Filter date range
        if (!empty($request->date_range)) {
            list($startDate, $endDate) = explode(' - ', $request->date_range);
            $query->whereBetween('start_date', [$startDate, $endDate]);
        }else{
            $startDate = null;
            $endDate = null;
        }

        $query->whereIn('object_model', array_keys(get_bookable_services()));
        $query->orderBy('id','desc');

        // Export data jika tombol "Export" ditekan
        if ($request->has('export')) { 
            $date = now()->format('d-m-Y H:i:s');
            $filename = 'Laporan Transaksi ' . $date . '.xlsx';
            $bookings = $query->get(); // Mengambil semua data booking
            return Excel::download(new BookingsExport($bookings,$startDate,$endDate), $filename); // Export sebagai Excel
        }

        $data = [
            'rows'                  => $query->paginate(20),
            'page_title'            => __("All Bookings"),
            'booking_manage_others' => $this->hasPermission('booking_manage_others'),
            'booking_update'        => $this->hasPermission('booking_update'),
            'statues'               => config('booking.statuses')
        ];

        return view('Report::admin.booking.index', $data);
    }

    public function bulkEdit(Request $request)
    {
        $ids = $request->input('ids');
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('No items selected'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Please select action'));
        }
        if ($action == "delete") {
            foreach ($ids as $id) {
                $query = Booking::where("id", $id);
                if (!$this->hasPermission('booking_manage_others')) {
                    $query->where("vendor_id", Auth::id());
                }
                $row = $query->first();
                if(!empty($row)){
                    $row->delete();
                    event(new BookingUpdatedEvent($row));

                }
            }
        } else {
            foreach ($ids as $id) {
                $query = Booking::where("id", $id);
                if (!$this->hasPermission('booking_manage_others')) {
                    $query->where("vendor_id", Auth::id());
                    $this->checkPermission('booking_update');
                }
                $item = $query->first();
                if(!empty($item)){
                    $item->status = $action;
                    $item->save();

                    if($action == Booking::CANCELLED) $item->tryRefundToWallet();
                    event(new BookingUpdatedEvent($item));
                }
            }
        }
        return redirect()->back()->with('success', __('Update success'));
    }

    public function email_preview(Request $request, $id)
    {
        $booking = Booking::find($id);
        return (new NewBookingEmail($booking))->render();
    }
}
