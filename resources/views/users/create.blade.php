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
                        class="block mb-2 text-sm font-medium text-gray-900"
                    >
                        {{ __("Select domains") }}
                    </label>

                    <x-input-error
                        :messages="$errors->get('domains')"
                        class="mt-2"
                    />
                    <ul
                        class="w-auto text-sm divide-y-2 font-medium text-gray-90 rounded-lg border-2 overflow-hidden"
                    >
                        @foreach ($domains as $domain)
                            <li class="w-full border-gray-200">
                                <div class="flex items-center ps-3">
                                    <input
                                        id="{{ $loop->index }}-domain"
                                        @checked(in_array($domain, old("domains") ?? []))
                                        type="checkbox"
                                        name="domains[]"
                                        value="{{ $domain }}"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded dark:ring-offset-gray-700 focus:ring-2 cursor-pointer"
                                    />
                                    <label
                                        for="{{ $loop->index }}-domain"
                                        class="break-all w-full py-3 ms-2 text-sm font-medium text-gray-900 cursor-pointer"
                                    >
                                        {{ $domain }}
                                    </label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
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
