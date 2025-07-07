<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Outgoing Item') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('outgoing_items.store') }}">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="date" :value="__('Date')" />
                            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" required />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="client" :value="__('Client')" />
                            <x-text-input id="client" class="block mt-1 w-full" type="text" name="client" required />
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
                            <x-input-label for="item_description" :value="__('Item Description')" />
                            <x-text-input id="item_description" class="block mt-1 w-full" type="text" name="item_description" required />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="quantity" :value="__('Quantity')" />
                            <x-text-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" min="1" required />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="person_in_charge" :value="__('Person in Charge')" />
                            <x-text-input id="person_in_charge" class="block mt-1 w-full" type="text" name="person_in_charge" required />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="remarks" :value="__('Remarks')" />
                            <x-text-input id="remarks" class="block mt-1 w-full" type="text" name="remarks" />
                        </div>
                        <div class="flex justify-end">
                            <x-primary-button>
                                {{ __('Add Item') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
