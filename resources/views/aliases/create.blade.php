<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route("aliases.index") }}" class="text-gray-600">
                {{ __("Aliases") }}
            </a>
            <span class="text-gray-400">/</span>
            <a>{{ __("Create alias") }}</a>
        </h2>
    </x-slot>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __("Create New Alias") }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __("Add a new alias to forward emails to other email addresses") }}
                </p>
            </header>

            <form method="POST" action="{{ route('aliases.store') }}" class="mt-6 space-y-6">
                @csrf

                <div>
                    <x-input-label for="alias" :value="__('Alias')" />
                    <x-text-input
                        id="alias"
                        name="alias"
                        type="text"
                        class="mt-1 block w-full"
                        value="{{ old('alias') }}"
                    />
                    <x-input-error :messages="$errors->get('alias')" class="mt-2"
                    />
                </div>

                <div>
                    <x-input-label for="forwards_to" :value="__('Forwards To')" />
                    <textarea
                        id="forwards_to"
                        name="forwards_to"
                        rows="3"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    >{{ old('forwards_to') }}</textarea>
                    <x-input-error :messages="$errors->get('forwards_to')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between">
                    <x-primary-button>{{ __("Create") }}</x-primary-button>
                </div>

                @if (session('success'))
                    <p class="text-green-600 mt-4">{{ session('success') }}</p>
                @endif
            </form>
        </div>
    </div>
</x-app-layout>
