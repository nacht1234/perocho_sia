<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\AvailableParkingSpace;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $bookings = Booking::with(['customer', 'space', 'confirmedBy'])
            ->where(function ($query) {
                $query->where('is_confirmed', true)
                    ->orWhere('status', 'unoccupied');
            })
            ->when($search, function ($query, $search) {
                $query->whereHas('customer', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('space', function ($q) use ($search) {
                    $q->where('bldg_floor_no', 'like', "%{$search}%")
                        ->orWhere('lot_no', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%");
                })
                ->orWhere('car_brand', 'like', "%{$search}%")
                ->orWhere('car_model', 'like', "%{$search}%")
                ->orWhere('license_plate', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(5);

        return view('bookings.index', compact('bookings', 'search'));
    }

    public function create()
    {
        $customers = Customer::all();
        $spaces = AvailableParkingSpace::where('status', 'available')->get();

        return view('bookings.create', compact('customers', 'spaces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'available_parking_space_id' => 'required|exists:available_parking_spaces,id',
            'car_brand' => 'required|string|max:100',
            'car_model' => 'required|string|max:100',
            'license_plate' => 'required|string|max:20',
        ]);

        $booking = Booking::create([
            'customer_id' => $request->customer_id,
            'available_parking_space_id' => $request->available_parking_space_id,
            'car_brand' => $request->car_brand,
            'car_model' => $request->car_model,
            'license_plate' => $request->license_plate,
        ]);

        $space = AvailableParkingSpace::findOrFail($request->available_parking_space_id);
        $space->status = 'booked';
        $space->save();

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
    }

    public function edit(Booking $booking)
    {
        $customers = Customer::all();
        $spaces = AvailableParkingSpace::all();

        return view('bookings.edit', compact('booking', 'customers', 'spaces'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'available_parking_space_id' => 'required|exists:available_parking_spaces,id',
            'car_brand' => 'required|string|max:100',
            'car_model' => 'required|string|max:100',
            'license_plate' => 'required|string|max:20',
        ]);

        if ($booking->available_parking_space_id !== (int) $request->available_parking_space_id) {
            $oldSpace = AvailableParkingSpace::find($booking->available_parking_space_id);
            if ($oldSpace) {
                $oldSpace->status = 'available';
                $oldSpace->save();
            }

            $newSpace = AvailableParkingSpace::find($request->available_parking_space_id);
            if ($newSpace) {
                $newSpace->status = 'booked';
                $newSpace->save();
            }
        }

        $booking->update([
            'customer_id' => $request->customer_id,
            'available_parking_space_id' => $request->available_parking_space_id,
            'car_brand' => $request->car_brand,
            'car_model' => $request->car_model,
            'license_plate' => $request->license_plate,
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $space = $booking->space;
        if ($space) {
            $space->status = 'available';
            $space->save();
        }

        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking cancelled successfully.');
    }

    public function downloadPDF()
    {
        $bookings = Booking::with('customer')->get();
        $pdf = Pdf::loadView('bookings.pdf', compact('bookings'));
        return $pdf->download('bookings_report.pdf');
    }
}
