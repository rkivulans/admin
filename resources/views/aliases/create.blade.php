<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <h1 class="text-lg font-medium text-gray-900">Aliases</h1>

        <form method="post" action="{{ route('aliases.create') }}" class="mt-4 space-y-4">
        @csrf

            <div>
                <x-input-label for="alias" :value="__('Alias')" />
                <x-text-input id="alias" name="alias" type="text" class="mt-1 block w-full"/>
            </div>

            <div>
                <x-input-label for="forwards_to" :value="__('Forwards To')" />
                <textarea id="forwards_to" name="forwards_to" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
            </div>

            <div class="flex items-center justify-between">
                <x-primary-button>{{ __('Create') }}</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>