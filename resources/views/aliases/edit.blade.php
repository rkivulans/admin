<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route("aliases.index") }}" class="text-gray-600">
                {{ __("Aliases") }}
            </a>
            <span class="text-gray-400">/</span>
            {{ __(":alias update", ["alias" => $address]) }}
        </h2>
    </x-slot>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __("Update Alias") }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __("Update the recipients that receive emails sent to this alias.") }}
                </p>
            </header>

            <form method="POST" action="{{ route('aliases.update', ['alias' => $address]) }}" class="mt-6 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="alias" :value="__('Alias')" />
                    <x-text-input
                        id="alias"
                        name="alias"
                        type="text"
                        value="{{ $address }}"
                        class="mt-1 block w-full bg-gray-200"
                        readonly
                    />
                </div>

                <div>
                    <x-input-label for="forwards_to" :value="__('Forwards To')" />
                    <textarea
                        id="forwards_to"
                        name="forwards_to"
                        rows="3"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    >{{ old('forwards_to', implode(", ", $forwards_to)) }}</textarea>
                    @error('forwards_to')
                        <div class="text-red-600 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <x-primary-button>{{ __("Update") }}</x-primary-button>
                </div>

                @if (session('success'))
                    <p class="text-green-600 mt-4">{{ session('success') }}</p>
                @endif
            </form>
        </div>
    </div>
</x-app-layout>
