<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kitchen Dashboard') }}
        </h2>
    </x-slot>

    <x-alert />

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <x-stat-card title="Pending Orders" :value="$pendingOrders" />
                <x-stat-card title="In-Progress Orders" :value="$inProgressOrders" />
                <x-stat-card title="Completed Orders" :value="$completedOrders" />
                <x-stat-card title="Cancelled Orders" :value="$cancelledOrders" />

            </div>

            <div>
                <x-recent-orders :orders="$recentOrders" />
            </div>
        </div>
    </div>
</x-app-layout>
