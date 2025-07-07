<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowedItem;

class BorrowController extends Controller
{
    public function create()
    {
        return view('borrow.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'borrower_name' => 'required|string',
            'equipment_name' => 'required|string',
            'equipment_quantity' => 'required|integer|min:1',
            'product_name' => 'required|string',
            'product_quantity' => 'required|integer|min:1',
            'location' => 'required|string',
            'purpose' => 'required|string',
            'borrowed_time' => 'required',
        ]);
        BorrowedItem::create([
            'date' => $validated['date'],
            'borrower_name' => $validated['borrower_name'],
            'equipment_name' => $validated['equipment_name'],
            'equipment_quantity' => $validated['equipment_quantity'],
            'product_name' => $validated['product_name'],
            'product_quantity' => $validated['product_quantity'],
            'location' => $validated['location'],
            'purpose' => $validated['purpose'],
            'borrowed_time' => $validated['borrowed_time'],
        ]);
        return redirect()->route('dashboard')->with('success', 'Borrowed item submitted successfully! Your request has been sent to staff.');
    }
}
