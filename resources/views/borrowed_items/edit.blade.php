<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Borrowed Item') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('borrowed_items.update', $item->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <x-input-label for="returned_item" :value="__('Returned Item')" />
                            <x-text-input id="returned_item" class="block mt-1 w-full" type="text" name="returned_item" value="{{ old('returned_item', $item->returned_item) }}" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="quantity_returned" :value="__('Quantity Returned')" />
                            <x-text-input id="quantity_returned" class="block mt-1 w-full" type="number" name="quantity_returned" min="0" value="{{ old('quantity_returned', $item->quantity_returned) }}" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="returned_time" :value="__('Returned Time')" />
                            <x-text-input id="returned_time" class="block mt-1 w-full" type="time" name="returned_time" value="{{ old('returned_time', $item->returned_time) }}" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="person_in_charge" :value="__('Person in Charge')" />
                            <x-text-input id="person_in_charge" class="block mt-1 w-full" type="text" name="person_in_charge" value="{{ old('person_in_charge', $item->person_in_charge) }}" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="remarks" :value="__('Remarks')" />
                            <x-text-input id="remarks" class="block mt-1 w-full" type="text" name="remarks" value="{{ old('remarks', $item->remarks) }}" />
                        </div>
                        <div class="flex justify-end">
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
