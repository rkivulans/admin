<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route("users.index") }}" class="text-gray-600">
                {{ __("Users") }}
            </a>
            <span class="text-gray-400">/</span>
            <a>{{ __("Create user") }}</a>
        </h2>
    </x-slot>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __("Create New User") }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __("Add a new user with available domains") }}
                </p>
            </header>

            <form
                method="POST"
                action="{{ route("users.store") }}"
                class="mt-6 space-y-6"
            >
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input
                        id="name"
                        name="name"
                        type="text"
                        class="mt-1 block w-full"
                        value="{{ old('name') }}"
                    />
                    <x-input-error
                        :messages="$errors->get('name')"
                        class="mt-2"
                    />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email Address')" />
                    <x-text-input
                        id="email"
                        name="email"
                        type="text"
                        class="mt-1 block w-full"
                        value="{{ old('email') }}"
                    />
                    <x-input-error
                        :messages="$errors->get('email')"
                        class="mt-2"
                    />
                </div>

                <div>
                    <x-input-label for="domains" :value="__('Domains')" />
                    <textarea
                        id="domains"
                        name="domains"
                        rows="3"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm min-h-12"
                    >
{{ old("domains") }}</textarea
                    >
                    <x-input-error
                        :messages="$errors->get('domains')"
                        class="mt-2"
                    />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="mt-1 block w-full"
                        autocomplete="new-password"
                    />
                    <x-input-error
                        :messages="$errors->get('password')"
                        class="mt-2"
                    />
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>
                        {{ __("Create") }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
