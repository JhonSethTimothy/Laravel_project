<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Borrowed Item') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Borrowed Items Table</h3>
                    <div class="mb-4">
                        <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Send Tables</button>
                    </div>
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                            {{ session('success') }}
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
                                    <th>Send</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
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
                                        <form action="{{ route('borrowed_items.destroy', $item->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline ml-2">Delete</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('borrowed_items.sendToAdmin', $item->id) }}" method="POST" style="display:inline">
                                            @csrf
                                            <button type="submit" class="px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700" @if($item->sent_to_admin) disabled class="opacity-50 cursor-not-allowed" @endif>
                                                {{ $item->sent_to_admin ? 'Sent' : 'Send' }}
                                            </button>
                                        </form>
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
