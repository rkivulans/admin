<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="flex justify-between">
            <h1 class="text-lg">Aliases</h1>
            <x-primary-button as="a" href="{{ route('aliases.create') }}">Create</x-primary-button>
        </div> 
        @dump($aliases)
        <section class="mt-10">
            <h2 class="text-lg font-semibold text-gray-900">Mails</h2>

            <div class="mt-4 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Alias</th>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Forwards To</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6"><span class="sr-only">Edit</span></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($aliases as $alias)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-6">{{ $alias->address_display }}</td>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-500">
                                                @foreach ($alias->forwards_to as $forward)
                                                    {{ $forward }}<br>
                                                @endforeach
                                            </td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <a href="{{ route('aliases.edit', ['alias' => $alias->address]) }}" class="text-indigo-600 hover:text-indigo-900">Edit<span class="sr-only">, {{ $alias->address_display }}</span></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>