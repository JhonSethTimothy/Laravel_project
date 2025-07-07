<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Your Notifications</h3>
                    {{-- Recent Actions --}}
                    @if(count($notifications) > 0)
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-700 dark:text-gray-200 mb-2">Recent Actions</h4>
                            <ul class="flex flex-col gap-2">
                                @foreach($notifications->take(3) as $recent)
                                    <li class="p-3 rounded bg-gray-100 dark:bg-gray-700 flex items-center gap-2">
                                        <span class="inline-block w-2 h-2 rounded-full bg-blue-500"></span>
                                        <span class="text-sm">{{ $recent->data['borrower_name'] ?? '' }} - {{ $recent->data['equipment_name'] ?? '' }} - {{ $recent->created_at->diffForHumans() }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <ul>
                        @forelse($notifications as $notification)
                            <li class="mb-4 p-4 border-l-4 @if($notification->unread()) border-yellow-500 bg-yellow-50 dark:bg-yellow-900 @else border-gray-300 dark:border-gray-700 @endif">
                                <div class="flex items-center gap-2">
                                    @if($notification->unread())
                                        <span class="inline-block w-3 h-3 rounded-full bg-yellow-500"></span>
                                        <span class="px-2 py-1 bg-yellow-200 text-yellow-800 text-xs rounded font-bold">New</span>
                                    @endif
                                    @if(($notification->data['type'] ?? null) === 'borrowed')
                                        <strong>Borrowed Item Sent:</strong> {{ $notification->data['borrower_name'] ?? '' }} - {{ $notification->data['equipment_name'] ?? '' }} - {{ $notification->data['product_name'] ?? '' }}
                                    @elseif(($notification->data['type'] ?? null) === 'incoming')
                                        <strong>Incoming Item Sent:</strong> {{ $notification->data['serial_number'] ?? '' }} - {{ $notification->data['model'] ?? '' }} - {{ $notification->data['brand'] ?? '' }} - {{ $notification->data['item_description'] ?? '' }} - Qty: {{ $notification->data['quantity'] ?? '' }}
                                    @elseif(($notification->data['type'] ?? null) === 'outgoing')
                                        <strong>Outgoing Item Sent:</strong> {{ $notification->data['client'] ?? '' }} - {{ $notification->data['location'] ?? '' }} - {{ $notification->data['purpose'] ?? '' }} - {{ $notification->data['item_description'] ?? '' }} - Qty: {{ $notification->data['quantity'] ?? '' }}
                                    @else
                                        <strong>Item Sent:</strong> #{{ $notification->data['id'] ?? '' }}
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                                @if($notification->unread())
                                    <form method="POST" action="{{ route('notifications.markAsRead', $notification->id) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="ml-2 text-blue-600 hover:underline">Mark as read</button>
                                    </form>
                                @endif
                            </li>
                        @empty
                            <li>No notifications found.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
