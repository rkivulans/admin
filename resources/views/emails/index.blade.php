<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Mailboxes") }}
        </h2>
    </x-slot>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="flex justify-between">
            <h1 class="text-lg">{{ __("Mailboxes") }}</h1>
            <x-primary-button as="a" href="{{ route('emails.create') }}">
                {{ __("Create") }}
            </x-primary-button>
        </div>

        <div class="mt-8 w-full rounded-lg ring-1 ring-slate-900/10 bg-white">
            @foreach ($users->groupBy(function ($user, int $key) {
                    return explode("@", $user->email, 2)[1];
                })
                as $groupName => $groupedUsers)
                <div class="relative group">
                    <div
                        class="sticky top-0 z-10 border-y border-b-gray-200 border-t-gray-100 bg-gray-50 px-3 py-1.5 text-sm font-semibold leading-6 text-gray-900 group-first:rounded-t-lg"
                    >
                        <h3>{{ $groupName }}</h3>
                    </div>
                    <ul role="list" class="divide-y divide-gray-100">
                        @foreach ($groupedUsers as $user)
                            <li
                                class="flex items-center justify-between gap-x-5 py-4 px-3 @if ($user->email == session('lastId')) bg-gray-50 @endif"
                            >
                                <div class="min-w-0 flex-auto">
                                    <p class="text-sm leading-6 text-gray-900">
                                        {{ $user->email }}
                                    </p>
                                </div>

                                @if ($user->email === Auth::user()->email)
                                    <span class="text-sm text-gray-500">
                                        {{ __("(You)") }}
                                    </span>
                                @else
                                    <a
                                        href="{{ route("emails.edit", ["email" => $user->email]) }}"
                                        class="rounded-full bg-white px-2.5 py-1 text-xs font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                    >
                                        {{ __("Edit") }}
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
