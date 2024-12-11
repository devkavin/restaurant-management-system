<div class="p-4 bg-white rounded-lg shadow-md">
    <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ __('Recent Orders') }}</h3>
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Order ID
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Concessions
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($orders as $order)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $order->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @foreach ($order->concessions as $concession)
                            <div>{{ $concession->name }} x {{ $concession->pivot->quantity }}</div>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <x-status-label :status="$order->status">
                            {{ $order->status }}
                        </x-status-label>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
