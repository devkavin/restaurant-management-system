@props(['status'])

@php
    $statusClasses = [
        'Pending' => 'bg-yellow-100 text-yellow-800',
        'In-Progress' => 'bg-blue-100 text-blue-800',
        'Completed' => 'bg-green-100 text-green-800',
        'Cancelled' => 'bg-red-100 text-red-800',
    ];
    $statusClass = $statusClasses[$status] ?? 'bg-gray-100 text-gray-800';
@endphp

<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
    {{ $slot }}
</span>
