<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Aliases") }}
        </h2>
    </x-slot>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="flex justify-between">
            <h1 class="text-lg">{{ __("Aliases") }}</h1>
            <x-primary-button as="a" href="{{ route('aliases.create') }}">
                {{ __("Create") }}
            </x-primary-button>
        </div>

        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                        <ul role="list" class="divide-y divide-gray-100">
                            @foreach ($aliases->groupBy(function ($alias, int $key) {
                                    return explode("@", $alias->address_display, 2)[1];
                                }) 
                                as $groupName => $groupedAliases)
                                <li class="flex gap-x-4 py-5 bg-gray-200 px-4">
                                    <div class="flex-auto">
                                        <p class="whitespace-nowrap py-2 text-sm text-gray-900 font-semibold">
                                            {{ $groupName }}
                                        </p>
                                    </div>
                                </li>
                                @foreach ($groupedAliases as $alias)
                                    <li class="flex gap-x-4 py-5 px-4 @if ($alias->address_display == session('lastId')) bg-gray-50 @endif">
                                        <div class="flex-auto">
                                            <div class="flex justify-between items-center mb-2">
                                                <p class="text-sm text-gray-900">
                                                    {{ $alias->address_display }}
                                                </p>
                                                @if (! $alias->auto)
                                                    <a href="{{ route("aliases.edit", ["alias" => $alias->address]) }}"
                                                        class="text-indigo-600 hover:text-indigo-900 text-sm font-medium pr-2">
                                                        {{ __("Edit") }}
                                                        <span class="sr-only">, {{ $alias->address_display }}</span>
                                                    </a>
                                                @endif
                                            </div>
                                            <p class="mt-1 line-clamp-2 text-sm text-gray-600">
                                                @foreach ($alias->forwards_to as $forward)
                                                    {{ $forward }}<br />
                                                @endforeach
                                            </p>
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

    <ul role="list" class="divide-y divide-gray-100">
        <li class="flex gap-x-4 py-5">
            <img
                class="h-12 w-12 flex-none rounded-full bg-gray-50"
                src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                alt=""
            />
            <div class="flex-auto">
                <div class="flex items-baseline justify-between gap-x-4">
                    <p class="text-sm font-semibold leading-6 text-gray-900">
                        Leslie Alexander
                    </p>
                    <p class="flex-none text-xs text-gray-600">
                        <time datetime="2023-03-04T15:54Z">1d ago</time>
                    </p>
                </div>
                <p class="mt-1 line-clamp-2 text-sm leading-6 text-gray-600">
                    Explicabo nihil laborum. Saepe facilis consequuntur in
                    eaque. Consequatur perspiciatis quam. Sed est illo quia.
                    Culpa vitae placeat vitae. Repudiandae sunt exercitationem
                    nihil nisi facilis placeat minima eveniet.
                </p>
            </div>
        </li>
        <li class="flex gap-x-4 py-5">
            <img
                class="h-12 w-12 flex-none rounded-full bg-gray-50"
                src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                alt=""
            />
            <div class="flex-auto">
                <div class="flex items-baseline justify-between gap-x-4">
                    <p class="text-sm font-semibold leading-6 text-gray-900">
                        Michael Foster
                    </p>
                    <p class="flex-none text-xs text-gray-600">
                        <time datetime="2023-03-03T14:02Z">2d ago</time>
                    </p>
                </div>
                <p class="mt-1 line-clamp-2 text-sm leading-6 text-gray-600">
                    Laudantium quidem non et saepe vel sequi accusamus
                    consequatur et. Saepe inventore veniam incidunt cumque et
                    laborum nemo blanditiis rerum. A unde et molestiae autem ad.
                    Architecto dolor ex accusantium maxime cumque laudantium
                    itaque aut perferendis.
                </p>
            </div>
        </li>
        <li class="flex gap-x-4 py-5">
            <img
                class="h-12 w-12 flex-none rounded-full bg-gray-50"
                src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                alt=""
            />
            <div class="flex-auto">
                <div class="flex items-baseline justify-between gap-x-4">
                    <p class="text-sm font-semibold leading-6 text-gray-900">
                        Dries Vincent
                    </p>
                    <p class="flex-none text-xs text-gray-600">
                        <time datetime="2023-03-03T13:23Z">2d ago</time>
                    </p>
                </div>
                <p class="mt-1 line-clamp-2 text-sm leading-6 text-gray-600">
                    Quia animi harum in quis quidem sint. Ipsum dolorem
                    molestias veritatis quis eveniet commodi assumenda
                    temporibus. Dicta ut modi alias nisi. Veniam quia velit et
                    ut. Id quas ducimus reprehenderit veniam fugit amet fugiat
                    ipsum eius. Voluptas nobis earum in in vel corporis nisi.
                </p>
            </div>
        </li>
        <li class="flex gap-x-4 py-5">
            <img
                class="h-12 w-12 flex-none rounded-full bg-gray-50"
                src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                alt=""
            />
            <div class="flex-auto">
                <div class="flex items-baseline justify-between gap-x-4">
                    <p class="text-sm font-semibold leading-6 text-gray-900">
                        Lindsay Walton
                    </p>
                    <p class="flex-none text-xs text-gray-600">
                        <time datetime="2023-03-02T21:13Z">3d ago</time>
                    </p>
                </div>
                <p class="mt-1 line-clamp-2 text-sm leading-6 text-gray-600">
                    Unde dolore exercitationem nobis reprehenderit rerum
                    corporis accusamus. Nemo suscipit temporibus quidem dolorum.
                    Nobis optio quae atque blanditiis aspernatur doloribus sit
                    accusamus. Sunt reiciendis ut corrupti ab debitis dolorem
                    dolorem nam sit. Ducimus nisi qui earum aliquam. Est nam
                    doloribus culpa illum.
                </p>
            </div>
        </li>
    </ul>
</x-app-layout>
