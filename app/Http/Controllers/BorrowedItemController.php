<?php

namespace App\Http\Controllers;

use App\Models\BorrowedItem;
use Illuminate\Http\Request;
use App\Notifications\BorrowedItemSentNotification;
use App\Models\User;
use App\Models\IncomingItem;
use App\Models\OutgoingItem;

class BorrowedItemController extends Controller
{
    public function index(Request $request = null)
    {
        // If this is the staff dashboard, show only the latest item and summary counts
        if ($request && $request->route() && $request->route()->getName() === 'dashboard') {
            $items = BorrowedItem::orderBy('created_at', 'desc')->take(1)->get();
            $totalBorrowed = BorrowedItem::count();
            $totalIncoming = IncomingItem::count();
            $totalOutgoing = OutgoingItem::count();
            return view('dashboard_staff', compact('items', 'totalBorrowed', 'totalIncoming', 'totalOutgoing'));
        }
        // Otherwise, show all items (for /borrowed-items)
        $items = BorrowedItem::all();
        return view('borrowed_items.index', compact('items'));
    }

    public function edit($id)
    {
        $item = BorrowedItem::findOrFail($id);
        return view('borrowed_items.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = BorrowedItem::findOrFail($id);
        $request->validate([
            'returned_item' => 'nullable|string',
            'quantity_returned' => 'nullable|integer',
            'returned_time' => 'nullable',
            'person_in_charge' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);
        $item->update($request->only(['returned_item', 'quantity_returned', 'returned_time', 'person_in_charge', 'remarks']));
        return redirect()->route('borrowed_items.index')->with('success', 'Borrowed item updated successfully.');
    }

    public function destroy($id)
    {
        $item = BorrowedItem::findOrFail($id);
        $item->delete();
        return redirect()->route('borrowed_items.index')->with('success', 'Borrowed item deleted successfully.');
    }

    public function sendToAdmin($id)
    {
        $item = BorrowedItem::findOrFail($id);
        $item->sent_to_admin = true;
        $item->save();
        // Notify all staff
        $staff = User::where('role', 'Staff')->get();
        foreach ($staff as $user) {
            $user->notify(new \App\Notifications\ItemSentNotification($item));
        }
        // Notify the technician who submitted
        $technician = auth()->user();
        if ($technician) {
            $technician->notify(new \App\Notifications\ItemSentNotification($item));
        }
        // Do not notify admins for borrowed items here
        return redirect()->back()->with('success', 'Table sent to staff successfully.');
    }

    public function sentTables()
    {
        $borrowedItems = BorrowedItem::where('sent_to_admin', true)->get();
        $incomingItems = IncomingItem::all();
        $outgoingItems = OutgoingItem::all();
        return view('sent_tables', compact('borrowedItems', 'incomingItems', 'outgoingItems'));
    }

    public function allTables()
    {
        $borrowedItems = BorrowedItem::all();
        $incomingItems = IncomingItem::all();
        $outgoingItems = OutgoingItem::all();
        return view('all_tables', compact('borrowedItems', 'incomingItems', 'outgoingItems'));
    }
}
