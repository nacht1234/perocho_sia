<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $customers = Customer::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('age', 'like', "%{$search}%")
                  ->orWhere('gender', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(5);
    
        return view('customers.index', compact('customers', 'search'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'age' => 'required|integer',
            'gender' => 'required',
            'phone' => 'required',
        ]);

        Customer::create($request->all());
        return redirect()->route('customers.index');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $customer->update($request->all());
        return redirect()->route('customers.index');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index');
    }

    public function downloadPDF()
    {
        $customers = Customer::all();
        $pdf = Pdf::loadView('customers.pdf', compact('customers'));
        return $pdf->download('customers_list.pdf');
    }
}

