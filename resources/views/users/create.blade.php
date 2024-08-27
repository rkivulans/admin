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
                    <label
                        for="domains"
                        class="block mb-2 font-medium text-gray-900 py-4 text-lg"
                    >
                        {{ __("Select domains") }}
                    </label>

                    <fieldset>
                        <legend class="sr-only">Domains</legend>
                        <div class="space-y-5">
                            @foreach ($domains as $domain)
                                <div class="relative flex items-start">
                                    <div class="flex h-6 items-center">
                                        <input
                                            id="{{ $loop->index }}-domain"
                                            @checked(in_array($domain, old("domains") ?? []))
                                            aria-describedby="domains-description"
                                            name="domains[]"
                                            value="{{ $domain }}"
                                            type="checkbox"
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                        />
                                    </div>
                                    <div class="ml-3 text-sm leading-6">
                                        <label
                                            for="{{ $loop->index }}-domain"
                                            class="font-medium text-gray-900"
                                        >
                                            {{ $domain }}
                                        </label>
                                        <span
                                            id="comments-description"
                                            class="text-gray-500"
                                        >
                                            <span class="sr-only">
                                                {{ $domain }}
                                            </span>
                                            Ko seit likt atstat tuksu?.
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </fieldset>

                    <x-input-error
                        :messages="$errors->get('domains')"
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
