<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <h1>Create email form</h1>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <section>
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Add New Email') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Add a new email address to your account.') }}
                </p>
            </header>

            <form method="get" action="{{ route('emails.index') }}" class="mt-6 space-y-6">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Email Address')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" autocomplete="email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Add Email') }}</x-primary-button>

                    @if (session('status') === 'email-added')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600"
                        >{{ __('Added.') }}</p>
                    @endif
                </div>
            </form>
        </section>
    </div>
    </div>
</x-app-layout>