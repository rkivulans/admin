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

        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                        <ul role="list" class="divide-y divide-gray-100">
                            @foreach ($users->groupBy(function ($user, int $key) {
                                    return explode("@", $user->email, 2)[1];
                                }) 
                                as $groupName => $groupedUsers)
                                <li class="flex gap-x-4 py-5 bg-gray-200 px-4">
                                    <div class="flex-auto">
                                        <p class="whitespace-nowrap py-2 text-sm text-gray-900 font-semibold">
                                            {{ $groupName }}
                                        </p>
                                    </div>
                                </li>
                                @foreach ($groupedUsers as $user)
                                    <li class="flex gap-x-4 py-5 px-4 @if ($user->email == session('lastId')) bg-gray-50 @endif">
                                        <div class="flex-auto">
                                            <div class="flex justify-between items-center mb-2">
                                                <p class="text-sm text-gray-900">
                                                    {{ $user->email }}
                                                </p>
                                                @if ($user->email === Auth::user()->email)
                                                    <span class="text-sm text-gray-500">{{ __("(You)") }}</span>
                                                @else
                                                    <a href="{{ route("emails.edit", ["email" => $user->email]) }}"
                                                       class="text-indigo-600 hover:text-indigo-900 text-sm font-medium pr-2">
                                                        {{ __("Edit") }}
                                                        <span class="sr-only">, {{ $user->email }}</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
