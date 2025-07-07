<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\BorrowedItem;
use App\Models\IncomingItem;
use App\Models\OutgoingItem;

class TableExportController extends Controller
{
    public function exportBorrowedPdf()
    {
        $items = BorrowedItem::all();
        $title = 'Borrowed Items';
        $pdf = Pdf::loadView('exports.borrowed_pdf', compact('items', 'title'));
        return $pdf->download('borrowed_items.pdf');
    }

    public function exportIncomingPdf()
    {
        $items = IncomingItem::all();
        $title = 'Incoming Items';
        $pdf = Pdf::loadView('exports.incoming_pdf', compact('items', 'title'));
        return $pdf->download('incoming_items.pdf');
    }

    public function exportOutgoingPdf()
    {
        $items = OutgoingItem::all();
        $title = 'Outgoing Items';
        $pdf = Pdf::loadView('exports.outgoing_pdf', compact('items', 'title'));
        return $pdf->download('outgoing_items.pdf');
    }
}
