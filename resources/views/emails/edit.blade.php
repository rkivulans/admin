<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route("emails.index") }}" class="text-gray-600">
                {{ __("Mailboxes") }}
            </a>
            <span class="text-gray-400">/</span>
            {{ __(":email reset", ["email" => $email]) }}
        </h2>
    </x-slot>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __("Reset Password for :email", ["email" => $email]) }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __("Ensure the account is using a long, random password to stay secure.") }}
                </p>
            </header>

            <form method="POST" action="{{ route('emails.update', ['email' => $email]) }}" class="mt-6 space-y-6">
                @csrf
                @method("put")

                <div>
                    <x-input-label
                        for="password"
                        :value="__('New Password')"
                    />
                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="mt-1 block w-full"
                        autocomplete="new-password"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __("Reset Password") }}</x-primary-button>

                    @if (session("status") === "password-updated")
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => (show = false), 2000)"
                            class="text-sm text-gray-600"
                        >
                            {{ __("Saved") }}
                        </p>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
