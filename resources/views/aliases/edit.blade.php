<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <h1 class="text-lg font-medium text-gray-900">Aliases</h1>

        <form method="post" action="{{ route('aliases.edit', ['alias' => $address]) }}" class="mt-4 space-y-4">
        @csrf
        @method('PUT')

            <div>
                <x-input-label for="alias" :value="__('Alias')" />
                <x-text-input id="alias" name="alias" type="text" value="{{ $address }}" class="mt-1 block w-full" />
            </div>

            <div>
                <x-input-label for="forwards_to" :value="__('Forwards To')" />
                <x-text-input id="forwards_to" name="forwards_to" type="text" value="{{ implode(', ', $forwards_to) }}" class="mt-1 block w-full" />
            </div>

            <div>
                <x-primary-button>{{ __('Save') }}</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>