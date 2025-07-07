<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Staff Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded shadow text-center">
                    <div class="text-2xl font-bold text-blue-700 dark:text-blue-300">{{ $totalBorrowed ?? 0 }}</div>
                    <div class="text-gray-700 dark:text-gray-200">Total Borrowed</div>
                </div>
                <div class="bg-green-100 dark:bg-green-900 p-4 rounded shadow text-center">
                    <div class="text-2xl font-bold text-green-700 dark:text-green-300">{{ $totalIncoming ?? 0 }}</div>
                    <div class="text-gray-700 dark:text-gray-200">Total Incoming</div>
                </div>
                <div class="bg-yellow-100 dark:bg-yellow-900 p-4 rounded shadow text-center">
                    <div class="text-2xl font-bold text-yellow-700 dark:text-yellow-300">{{ $totalOutgoing ?? 0 }}</div>
                    <div class="text-gray-700 dark:text-gray-200">Total Outgoing</div>
                </div>
            </div>
            <div class="flex space-x-4 mb-6">
                <a href="#" class="px-4 py-2 rounded @if(request()->is('incoming-items')) bg-blue-600 text-white @else bg-gray-200 text-gray-800 @endif">Incoming Items</a>
                <a href="#" class="px-4 py-2 rounded @if(request()->is('outgoing-items')) bg-blue-600 text-white @else bg-gray-200 text-gray-800 @endif">Outgoing Items</a>
                <a href="#" class="px-4 py-2 rounded @if(request()->is('dashboard') || request()->is('borrowed-items')) bg-blue-600 text-white @else bg-gray-200 text-gray-800 @endif">Borrowed Items</a>
                <a href="{{ route('all.tables') }}" class="ml-auto px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700 font-semibold">View All Tables</a>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in as Staff!") }}
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Borrowed Item</h3>
                    @if(($items ?? null) && count($items) > 0)
                        <div class="mb-2 text-lg text-blue-700 dark:text-blue-300 font-semibold">
                            Borrower: {{ $items[0]->borrower_name }}
                        </div>
                    @endif
                    <div class="overflow-x-auto">
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items ?? [] as $item)
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
                                    <td>
                                        <a href="{{ route('borrowed_items.edit', $item->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                    </td>
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
