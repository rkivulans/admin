<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Users") }}
        </h2>
    </x-slot>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="flex justify-between">
            <h1 class="text-lg">{{ __("Users") }}</h1>
            <x-primary-button as="a" href="{{ route('users.create') }}">
                {{ __("Create") }}
            </x-primary-button>
        </div>

        <div class="mt-8 w-full rounded-lg ring-1 ring-slate-900/10 bg-white">
            <ul role="list" class="divide-y divide-gray-100">
                @foreach ($users as $user)
                    <li
                        class="flex items-center justify-between gap-x-5 py-4 px-3 @if ($user->email == session('lastId')) bg-gray-50 @endif"
                    >
                        <div class="min-w-0 flex-auto">
                            <p
                                class="text-sm font-semibold leading-6 text-gray-900"
                            >
                                {{ $user->name }}
                                <span class="text-gray-500 font-normal">
                                    {{ $user->email }}
                                </span>
                            </p>
                            <p class="mt-1 line-clamp-2 text-xs text-gray-500">
                                {{ Arr::join($user->domains, ", ") }}
                            </p>
                        </div>
                        <a
                            href="{{ route("users.edit", ["user" => $user]) }}"
                            class="rounded-full bg-white px-2.5 py-1 text-xs font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                        >
                            {{ __("Edit") }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
