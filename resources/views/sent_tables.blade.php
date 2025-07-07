<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sent Tables') }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex space-x-4 mb-6">
                <a href="{{ route('incoming_items.index') }}" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Incoming Items</a>
                <a href="{{ route('outgoing_items.index') }}" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700">Outgoing Items</a>
                <a href="{{ route('borrowed_items.index') }}" class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Borrowed Items</a>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Sent Borrowed Items</h3>
                    <div class="overflow-x-auto mb-8">
                        <table class="min-w-full divide-y divide-gray-200">
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
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <h3 class="text-lg font-bold mb-4 mt-8">Incoming Items</h3>
                    <div class="overflow-x-auto mb-8">
                        <table class="min-w-full divide-y divide-gray-200">
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
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
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
