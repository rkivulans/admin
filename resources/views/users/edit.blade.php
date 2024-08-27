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
                    <h3>{{ __("Old domains:") }}</h3>
                    @foreach ($user->domains as $domain)
                        <small class="text-slate-600">{{ $domain }}</small>
                        <br />
                    @endforeach
                </div>

                <div>
                    <label
                        for="domains"
                        class="block mb-2 text-sm font-medium text-gray-900"
                    >
                        {{ __("Select domains") }}
                    </label>
                    <select
                        required
                        multiple
                        id="domains"
                        name="domains[]"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    >
                        @foreach ($domains as $domain)
                            <option class="text-base" value="{{ $domain }}">
                                {{ $domain }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-between">
                    <x-primary-button>{{ __("Update") }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
