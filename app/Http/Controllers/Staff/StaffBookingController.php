<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class StaffBookingController extends Controller
{

    /**
     * Show all unconfirmed bookings for staff to review.
     */
    public function index()
    {
        // Fetch bookings not yet confirmed
        $bookings = Booking::where('is_confirmed', false)->with('customer', 'space')->get();

        return view('staff.bookings.index', compact('bookings'));
    }

    /**
     * Confirm a booking.
     */
    public function confirm(Request $request, Booking $booking)
    {
        if ($booking->is_confirmed) {
            return redirect()->back()->with('error', 'Booking is already confirmed.');
        }

        $booking->is_confirmed = true;
        $booking->confirmed_by = Auth::id();
        $booking->is_read = false;
        $booking->save();

        $space = $booking->space;
        if ($space) {
            $space->status = 'booked';
            $space->save();
        }

        return redirect()->back()->with('success', 'Booking confirmed successfully.');
    }


    public function confirmedBookings(Request $request)
    {
        $search = $request->input('search');

        $bookings = Booking::with(['customer', 'space', 'confirmedBy'])
            ->where('is_confirmed', true)
            ->when($search, function ($query, $search) {
                $query->whereHas('customer', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('space', function ($q) use ($search) {
                    $q->where('bldg_floor_no', 'like', "%{$search}%")
                    ->orWhere('lot_no', 'like', "%{$search}%");                       
                })
                ->orWhere('car_brand', 'like', "%{$search}%")
                ->orWhere('car_model', 'like', "%{$search}%")
                ->orWhere('license_plate', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('staff.bookings.confirmed', compact('bookings', 'search'));
    }
    
    public function downloadPDF()
    {
        $spaces = AvailableParkingSpace::all();
        $pdf = Pdf::loadView('staff.bookings.pdf', compact('bookings'));
        return $pdf->download('confirmed-bookings.pdf');
    }
}
