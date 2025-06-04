<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AvailableParkingSpace;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AvailableParkingSpaceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $spaces = AvailableParkingSpace::when($search, function ($query, $search) {
            $query->where('bldg_floor_no', 'like', "%{$search}%")
                  ->orWhere('lot_no', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(5);
    
        return view('available_parking_spaces.index', compact('spaces', 'search'));
    }

    public function create()
    {
        return view('available_parking_spaces.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bldg_floor_no' => 'required',
            'lot_no' => 'required',
            'status' => 'required|in:available,booked',
        ]);

        AvailableParkingSpace::create($request->all());
        return redirect()->route('available-parking-spaces.index');
    }

    public function edit(AvailableParkingSpace $available_parking_space)
    {
        return view('available_parking_spaces.edit', compact('available_parking_space'));
    }

    public function update(Request $request, AvailableParkingSpace $available_parking_space)
    {
        $request->validate([
            'bldg_floor_no' => 'required',
            'lot_no' => 'required',
            'status' => 'required|in:available,booked',
        ]);

        $available_parking_space->update($request->all());
        return redirect()->route('available-parking-spaces.index');
    }

    public function destroy(AvailableParkingSpace $available_parking_space)
    {
        $available_parking_space->delete();
        return redirect()->route('available-parking-spaces.index');
    }

    public function downloadPDF()
    {
        $spaces = AvailableParkingSpace::all();
        $pdf = Pdf::loadView('available_parking_spaces.pdf', compact('spaces'));
        return $pdf->download('available_parking_spaces.pdf');
    }
}

