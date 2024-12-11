<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Order Management') }}
            </h2>
            <a href="{{ route('orders.create') }}">
                <x-primary-button class="hover:bg-green-800 hover:text-white">Create Order</x-primary-button>
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
                                    Order ID</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    User</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Concessions</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $order->id }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $order->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap">
                                        @foreach ($order->concessions as $concession)
                                            <span>{{ $concession->name }}
                                                ({{ $concession->pivot->quantity }})
                                            </span><br>
                                        @endforeach
                                    </td>
                                    @php
                                        $statusClasses = [
                                            'Pending' => 'bg-yellow-100 text-yellow-800',
                                            'In-Progress' => 'bg-blue-100 text-blue-800',
                                            'Completed' => 'bg-green-100 text-green-800',
                                        ];
                                        $statusClass = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800'; // Default to gray if not found
                                    @endphp

                                    <td class="px-6 py-4 whitespace-no-wrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                        @if ($order->status == 'Pending')
                                            <form action="{{ route('orders.send-to-kitchen', $order) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <x-primary-button class="text-indigo-600 hover:text-indigo-900">
                                                    Send to Kitchen
                                                </x-primary-button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
