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

        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                        <ul role="list" class="divide-y divide-gray-100">
                            @foreach ($users as $user)
                                <li class="flex flex-col gap-x-4 py-5 px-4 @if ($user->email == session('lastId')) bg-gray-50 @endif">
                                    <div class="flex-auto">
                                        <div class="flex justify-between items-center mb-2">
                                            <p class="text-sm text-gray-900">
                                                {{ $user->email }}
                                            </p>
                                            <a href="{{ route("users.edit", ["user" => $user]) }}"
                                               class="text-indigo-600 hover:text-indigo-900 text-sm font-medium pr-2">
                                                {{ __("Edit") }}
                                                <span class="sr-only">, {{ $user->email }}</span>
                                            </a>
                                        </div>
                                        <p class="mt-1 line-clamp-2 text-sm text-gray-600">
                                            @foreach ($user->domains as $domain)
                                                {{ $domain }}<br />
                                            @endforeach
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
