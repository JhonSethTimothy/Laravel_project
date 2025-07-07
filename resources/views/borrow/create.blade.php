<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Borrow Item') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('borrow.store') }}">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="date" :value="__('Date')" />
                            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" required />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="borrower_name" :value="__('Borrower Name')" />
                            <x-text-input id="borrower_name" class="block mt-1 w-full" type="text" name="borrower_name" required />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="equipment_name" :value="__('Equipment Name')" />
                            <x-text-input id="equipment_name" class="block mt-1 w-full" type="text" name="equipment_name" required />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="equipment_quantity" :value="__('Equipment Quantity')" />
                            <x-text-input id="equipment_quantity" class="block mt-1 w-full" type="number" name="equipment_quantity" min="1" required />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="product_name" :value="__('Product Name')" />
                            <x-text-input id="product_name" class="block mt-1 w-full" type="text" name="product_name" required />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="product_quantity" :value="__('Product Quantity')" />
                            <x-text-input id="product_quantity" class="block mt-1 w-full" type="number" name="product_quantity" min="1" required />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" required />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="purpose" :value="__('Purpose')" />
                            <x-text-input id="purpose" class="block mt-1 w-full" type="text" name="purpose" required />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="borrowed_time" :value="__('Borrowed Time')" />
                            <x-text-input id="borrowed_time" class="block mt-1 w-full" type="time" name="borrowed_time" required />
                        </div>
                        <div class="flex justify-end">
                            <x-primary-button>
                                {{ __('Submit') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
