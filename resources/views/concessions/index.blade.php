<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Concession Management') }}
            </h2>
            <a href="{{ route('concessions.create') }}">
                <x-primary-button class="hover:bg-green-800 hover:text-white">Add Concession</x-primary-button>
            </a>
        </div>
    </x-slot>

    <x-alert />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Description</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Image</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Price</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($concessions as $concession)
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $concession->name }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap">
                                        {{ $concession->description ?? 'No description' }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap">
                                        <img src="{{ Storage::url($concession->image) }}" alt="{{ $concession->name }}"
                                            class="w-16 h-16 object-cover rounded">
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap">${{ number_format($concession->price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                        <a href="{{ route('concessions.edit', $concession) }}">
                                            <x-primary-button
                                                class="hover:bg-indigo-800 hover:text-white">Edit</x-primary-button>
                                        </a>

                                        <form action="{{ route('concessions.destroy', $concession) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')

                                            <x-secondary-button type="submit"
                                                class="bg-red-600 hover:bg-red-800 hover:text-white px-4 py-2 rounded"
                                                onclick="return confirm('Are you sure you want to delete this concession?')">
                                                Delete
                                            </x-secondary-button>

                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                    <div class="mt-4">
                        {{ $concessions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
