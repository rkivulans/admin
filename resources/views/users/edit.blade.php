<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route("users.index") }}" class="text-gray-600">
                {{ __("Users") }}
            </a>
            <span class="text-gray-400">/</span>
            {{ __(":user update", ["user" => $user->email]) }}
        </h2>
    </x-slot>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __("Update User") }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __("Update Existing User") }}
                </p>
            </header>

            <form
                method="POST"
                action="{{ route("users.update", ["user" => $user]) }}"
                class="mt-6 space-y-6"
            >
                @csrf
                @method("PUT")

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input
                        id="email"
                        type="text"
                        value="{{ $user->email }}"
                        class="mt-1 block w-full bg-gray-200"
                        readonly
                    />
                </div>

                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input
                        id="name"
                        name="name"
                        type="text"
                        class="mt-1 block w-full"
                        value="{{ $user->name}}"
                    />
                    <x-input-error
                        :messages="$errors->get('name')"
                        class="mt-2"
                    />
                </div>

                <div>
                    <x-input-label for="max_emails" :value="__('Max Emails')" />
                    <x-text-input
                        id="max_emails"
                        name="max_emails"
                        type="number"
                        class="mt-1 block w-full"
                        value="{{ $user->max_emails}}"
                    />
                    <x-input-error
                        :messages="$errors->get('max_emails')"
                        class="mt-2"
                    />
                </div>

                <div>
                    <x-input-label for="max_aliases" :value="__('Max Aliases')" />
                    <x-text-input
                        id="max_aliases"
                        name="max_aliases"
                        type="number"
                        class="mt-1 block w-full"
                        value="{{ $user->max_aliases}}"
                    />
                    <x-input-error
                        :messages="$errors->get('max_aliases')"
                        class="mt-2"
                    />
                </div>

                <div>
                    <x-input-label for="max_storage" :value="__('Max Storage')" />
                    <x-text-input
                        id="max_storage"
                        name="max_storage"
                        type="number"
                        class="mt-1 block w-full"
                        value="{{ $user->max_storage}}"
                    />
                    <x-input-error
                        :messages="$errors->get('max_storage')"
                        class="mt-2"
                    />
                </div>

                <div>
                    <x-input-label for="max_domains" :value="__('Max Domains')" />
                    <x-text-input
                        id="max_domains"
                        name="max_domains"
                        type="number"
                        class="mt-1 block w-full"
                        value="{{ $user->max_domains}}"
                    />
                    <x-input-error
                        :messages="$errors->get('max_domains')"
                        class="mt-2"
                    />
                </div>

                <div>
                    <x-input-label :value="__('Domains')" class="mb-2" />
                    <fieldset>
                        <legend class="sr-only">__('Domains')</legend>
                        <div class="space-y-2">
                            @foreach ($domains->sort() as $domain)
                                <div class="relative flex items-start">
                                    <div class="flex h-6 items-center">
                                        <input
                                            id="{{ $loop->index }}-domain"
                                            @checked(in_array($domain, old("domains") ?? $user->domains))
                                            name="domains[]"
                                            value="{{ $domain }}"
                                            type="checkbox"
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                        />
                                    </div>
                                    <div class="ml-3 text-sm leading-6">
                                        <label
                                            for="{{ $loop->index }}-domain"
                                            class="text-gray-900"
                                        >
                                            {{ $domain }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach

                            <div class="relative flex items-start">
                                <div class="flex h-6 items-center">
                                    <input
                                        id="all-domains"
                                        @checked(in_array("*", old("domains") ?? $user->domains))
                                        name="domains[]"
                                        value="*"
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                    />
                                </div>
                                <div class="ml-3 text-sm leading-6">
                                    <label
                                        for="all-domains"
                                        class="text-gray-900"
                                    >
                                        {{ __("Admin for all domains") }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <x-input-error
                        :messages="$errors->get('domains')"
                        class="mt-2"
                    />
                    <x-input-error
                        :messages="$errors->get('domains.*')"
                        class="mt-2"
                    />
                </div>

                <div class="flex items-center justify-between">
                    <x-primary-button>{{ __("Update") }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
