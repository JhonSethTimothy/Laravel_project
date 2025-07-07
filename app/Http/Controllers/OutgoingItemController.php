<?php

namespace App\Http\Controllers;

use App\Models\OutgoingItem;
use Illuminate\Http\Request;

class OutgoingItemController extends Controller
{
    public function index()
    {
        $items = OutgoingItem::all();
        return view('outgoing_items.index', compact('items'));
    }

    public function create()
    {
        return view('outgoing_items.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'client' => 'required|string',
            'location' => 'required|string',
            'purpose' => 'required|string',
            'item_description' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'person_in_charge' => 'required|string',
            'remarks' => 'nullable|string',
        ]);
        OutgoingItem::create($validated);
        return redirect()->route('outgoing_items.index')->with('success', 'Outgoing item added successfully!');
    }

    public function edit($id)
    {
        $item = OutgoingItem::findOrFail($id);
        return view('outgoing_items.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = OutgoingItem::findOrFail($id);
        $validated = $request->validate([
            'date' => 'required|date',
            'client' => 'required|string',
            'location' => 'required|string',
            'purpose' => 'required|string',
            'item_description' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'person_in_charge' => 'required|string',
            'remarks' => 'nullable|string',
        ]);
        $item->update($validated);
        return redirect()->route('outgoing_items.index')->with('success', 'Outgoing item updated successfully!');
    }

    public function destroy($id)
    {
        $item = OutgoingItem::findOrFail($id);
        $item->delete();
        return redirect()->route('outgoing_items.index')->with('success', 'Outgoing item deleted successfully!');
    }

    public function sendToAdmin($id)
    {
        $item = \App\Models\OutgoingItem::findOrFail($id);
        $item->sent_to_admin = true;
        $item->save();
        // Notify all admins
        $admins = \App\Models\User::where('role', 'Admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\ItemSentNotification($item));
        }
        // Do not notify staff for outgoing items
        return redirect()->back()->with('success', 'Outgoing item sent to admin successfully.');
    }
}
