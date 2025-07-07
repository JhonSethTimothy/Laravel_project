<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Outgoing Items') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-bold">Outgoing Items Table</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('outgoing_items.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add Outgoing Item</a>
                            <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Send</button>
                        </div>
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
                                    <th>Client</th>
                                    <th>Location</th>
                                    <th>Purpose</th>
                                    <th>Item Description</th>
                                    <th>Quantity</th>
                                    <th>Person in Charge</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
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
                                    <td>
                                        <a href="{{ route('outgoing_items.edit', $item->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('outgoing_items.destroy', $item->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline ml-2">Delete</button>
                                        </form>
                                        <form action="{{ route('outgoing_items.sendToAdmin', $item->id) }}" method="POST" style="display:inline">
                                            @csrf
                                            <button type="submit" class="ml-2 px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs" @if($item->sent_to_admin) disabled class="opacity-50 cursor-not-allowed" @endif>
                                                @if($item->sent_to_admin) Sent @else Send @endif
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
