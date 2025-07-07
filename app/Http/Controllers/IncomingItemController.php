<?php

namespace App\Http\Controllers;

use App\Models\IncomingItem;
use Illuminate\Http\Request;

class IncomingItemController extends Controller
{
    public function index()
    {
        $items = IncomingItem::all();
        return view('incoming_items.index', compact('items'));
    }

    public function create()
    {
        return view('incoming_items.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'serial_number' => 'required|string',
            'model' => 'required|string',
            'brand' => 'required|string',
            'item_description' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'remarks' => 'nullable|string',
        ]);
        IncomingItem::create($validated);
        return redirect()->route('incoming_items.index')->with('success', 'Incoming item added successfully!');
    }

    public function edit($id)
    {
        $item = IncomingItem::findOrFail($id);
        return view('incoming_items.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = IncomingItem::findOrFail($id);
        $validated = $request->validate([
            'date' => 'required|date',
            'serial_number' => 'required|string',
            'model' => 'required|string',
            'brand' => 'required|string',
            'item_description' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'remarks' => 'nullable|string',
        ]);
        $item->update($validated);
        return redirect()->route('incoming_items.index')->with('success', 'Incoming item updated successfully!');
    }

    public function destroy($id)
    {
        $item = IncomingItem::findOrFail($id);
        $item->delete();
        return redirect()->route('incoming_items.index')->with('success', 'Incoming item deleted successfully!');
    }

    public function sendToAdmin($id)
    {
        $item = \App\Models\IncomingItem::findOrFail($id);
        $item->sent_to_admin = true;
        $item->save();
        // Notify all admins
        $admins = \App\Models\User::where('role', 'Admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\ItemSentNotification($item));
        }
        // Do not notify staff for incoming items
        return redirect()->back()->with('success', 'Incoming item sent to admin successfully.');
    }
}
