<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\AvailableParkingSpace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerBookingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $bookings = Booking::with('space')
            ->where('customer_id', Auth::user()->customer->id)
            ->where('status', '!=', 'unoccupied')
            ->when($search, function ($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('car_brand', 'like', "%{$search}%")
                    ->orWhere('car_model', 'like', "%{$search}%")
                    ->orWhere('license_plate', 'like', "%{$search}%")
                    ->orWhereHas('space', function ($q2) use ($search) {
                        $q2->where('bldg_floor_no', 'like', "%{$search}%")
                            ->orWhere('lot_no', 'like', "%{$search}%");
                    });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('customer.bookings.index', compact('bookings', 'search'));
    }

    public function create()
    {
        $spaces = AvailableParkingSpace::where('status', 'available')
        ->whereDoesntHave('bookings', function ($query) {
            $query->where('is_confirmed', false);
        })->get();

        return view('customer.bookings.create', compact('spaces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'available_parking_space_id' => 'required|exists:available_parking_spaces,id',
            'car_brand' => 'required|string|max:255',
            'car_model' => 'required|string|max:255',
            'license_plate' => 'required|string|max:20',
        ]);

        $space = AvailableParkingSpace::findOrFail($request->available_parking_space_id);

        if ($space->status === 'booked') {
            return redirect()->back()->withErrors(['available_parking_space_id' => 'This parking space is already booked.']);
        }

        $booking = Booking::create([
            'available_parking_space_id' => $request->available_parking_space_id,
            'customer_id' => Auth::user()->customer->id,
            'car_brand' => $request->car_brand,
            'car_model' => $request->car_model,
            'license_plate' => $request->license_plate,
            'is_confirmed' => false,
        ]);

        return redirect()->route('customer.bookings.index')->with('success', 'Booking submitted for confirmation.');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->customer_id !== Auth::user()->customer->id) {
            abort(403);
        }

        if ($booking->is_confirmed) {
            $booking->status = 'unoccupied';
            $booking->space->update(['status' => 'available']);
        } else {
            $booking->status = 'cancelled';
        }

        $booking->save();

        $message = $booking->is_confirmed ? 'Parking space unoccupied.' : 'Booking cancelled.';
        return back()->with('success', $message);
    }

    public function downloadPDF()
    {
        $bookings = Booking::with('customer')->get();
        $pdf = Pdf::loadView('customer.bookings.pdf', compact('bookings'));
        return $pdf->download('my_bookings.pdf');
    }

    public function notifications()
    {
        $customer = Auth::user()->customer;

        $notifications = Booking::where('customer_id', $customer->id)
            ->where('is_confirmed', true)
            ->where('is_read', false)
            ->with('space')
            ->get();

        foreach ($notifications as $note) {
            $note->is_read = true;
            $note->save();
        }

        return view('customer.notifications.index', compact('notifications'));
    }

    public function unoccupy(Booking $booking)
    {
        if ($booking->customer_id !== Auth::user()->customer->id || !$booking->is_confirmed) {
            abort(403);
        }

        $booking->status = 'unoccupied';
        $booking->save();

        $booking->space->status = 'available';
        $booking->space->save();

        return redirect()->route('customer.bookings.index')->with('success', 'Booking unoccupied.');
    }
}
