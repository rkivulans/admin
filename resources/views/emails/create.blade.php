<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route("emails.index") }}" class="text-gray-600">
                {{ __("Mailboxes") }}
            </a>
            <span class="text-gray-400">/</span>
            <a>{{ __("Create mailbox") }}</a>
        </h2>
    </x-slot>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __("Create New Mailbox") }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __("Add a new email address to your domain.") }}
                </p>
            </header>

            <form method="POST" action="{{ route('emails.store') }}" class="mt-6 space-y-6">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Email Address')" />
                    <x-text-input
                        id="email"
                        name="email"
                        type="text"
                        class="mt-1 block w-full"
                        value="{{ old('email') }}"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2"
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
                    <x-input-error :messages="$errors->get('password')" class="mt-2"
                    />
                </div>

                <div>
                    <x-input-label for="role" :value="__('Role')" />
                    <select
                        id="role"
                        name="role"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    >
                        <option value="" disabled selected>
                            Choose a role
                        </option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    
                    <x-input-error :messages="$errors->get('role')" class="mt-2"
                    />
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>
                        {{ __("Add Email") }}
                    </x-primary-button>
                </div>

                @if (session('success'))
                    <p class="text-green-600 mt-4">{{ session('success') }}</p>
                @endif
            </form>
        </div>
    </div>
</x-app-layout>
