<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('View All Tables') }}
        </h2>
    </x-slot>
    <div class="py-12 space-y-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Borrowed Items</h3>
                    <div class="overflow-x-auto print-area" id="borrowed-table-area">
                        <table id="borrowed-table" class="min-w-full divide-y divide-gray-200 mb-8">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Date</th>
                                    <th>Borrower</th>
                                    <th>Equipment Name</th>
                                    <th>Equipment Qty</th>
                                    <th>Product Name</th>
                                    <th>Product Qty</th>
                                    <th>Location</th>
                                    <th>Purpose</th>
                                    <th>Borrowed Time</th>
                                    <th>Returned Item</th>
                                    <th>Qty Returned</th>
                                    <th>Returned Time</th>
                                    <th>Person in Charge</th>
                                    <th>Remarks</th>
                                    <th>Sent to Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($borrowedItems as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->borrower_name }}</td>
                                    <td>{{ $item->equipment_name }}</td>
                                    <td>{{ $item->equipment_quantity }}</td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->product_quantity }}</td>
                                    <td>{{ $item->location }}</td>
                                    <td>{{ $item->purpose }}</td>
                                    <td>{{ $item->borrowed_time }}</td>
                                    <td>{{ $item->returned_item }}</td>
                                    <td>{{ $item->quantity_returned }}</td>
                                    <td>{{ $item->returned_time }}</td>
                                    <td>{{ $item->person_in_charge }}</td>
                                    <td>{{ $item->remarks }}</td>
                                    <td>{{ $item->sent_to_admin ? 'Yes' : 'No' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <h3 class="text-lg font-bold mb-4 mt-8">Incoming Items</h3>
                    <div class="overflow-x-auto print-area" id="incoming-table-area">
                        <table id="incoming-table" class="min-w-full divide-y divide-gray-200 mb-8">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Date</th>
                                    <th>Serial Number</th>
                                    <th>Model</th>
                                    <th>Brand</th>
                                    <th>Item Description</th>
                                    <th>Quantity</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($incomingItems as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->serial_number }}</td>
                                    <td>{{ $item->model }}</td>
                                    <td>{{ $item->brand }}</td>
                                    <td>{{ $item->item_description }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->remarks }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <h3 class="text-lg font-bold mb-4 mt-8">Outgoing Items</h3>
                    <div class="overflow-x-auto print-area" id="outgoing-table-area">
                        <table id="outgoing-table" class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Date</th>
                                    <th>Client</th>
                                    <th>Location</th>
                                    <th>Purpose</th>
                                    <th>Item Description</th>
                                    <th>Quantity</th>
                                    <th>Person in Charge</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($outgoingItems as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->client }}</td>
                                    <td>{{ $item->location }}</td>
                                    <td>{{ $item->purpose }}</td>
                                    <td>{{ $item->item_description }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->person_in_charge }}</td>
                                    <td>{{ $item->remarks }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('styles')
<style>
@media print {
    body * { visibility: hidden !important; }
    .print-area, .print-area * { visibility: visible !important; }
    .print-area { position: absolute; left: 0; top: 0; width: 100vw; background: white; padding: 2rem; }
    .print-area h3 { margin-top: 0; }
    .print-area table { width: 100%; border-collapse: collapse; }
    .print-area th, .print-area td { border: 1px solid #333; padding: 8px; }
}
</style>
@endpush

@push('scripts')
<script>
function printTable(tableId, heading) {
    var table = document.getElementById(tableId);
    var printArea = table.closest('.print-area');
    var printContents = printArea.outerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}

function exportTableToCSV(tableId, filename) {
    var csv = [];
    var rows = document.getElementById(tableId).querySelectorAll('tr');
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll('th, td');
        for (var j = 0; j < cols.length; j++)
            row.push('"' + cols[j].innerText.replace(/"/g, '""') + '"');
        csv.push(row.join(","));
    }
    // Download CSV
    var csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
    var downloadLink = document.createElement("a");
    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}
</script>
@endpush
