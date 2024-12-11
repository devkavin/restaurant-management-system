<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Order') }}
        </h2>
    </x-slot>

    <x-alert />

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="send_to_kitchen_time" class="block text-sm font-medium text-gray-700">
                                {{ __('Send to Kitchen Time') }}
                            </label>
                            <input type="datetime-local" name="send_to_kitchen_time" id="send_to_kitchen_time"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">
                                {{ __('Concessions') }}
                            </label>

                            <div id="concessions-container">
                                <div class="concession-item flex space-x-4 mb-2">
                                    <select name="concessions[0][id]" class="concession-select w-full" required>
                                        <option value="">Select a Concession</option>
                                        @foreach ($concessions as $concession)
                                            <option value="{{ $concession->id }}">{{ $concession->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="concessions[0][quantity]"
                                        class="w-20 border-gray-300 rounded-md" placeholder="Qty" min="1"
                                        required>
                                    <button type="button"
                                        class="remove-concession bg-red-500 text-white px-2 py-1 rounded">
                                        &times;
                                    </button>
                                </div>
                            </div>

                            <button type="button" id="add-concession"
                                class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">
                                + Add Concession
                            </button>
                        </div>

                        <div>
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded shadow">
                                {{ __('Create Order') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let concessionIndex = 1;

            // Add new concession row
            document.getElementById('add-concession').addEventListener('click', function() {
                const container = document.getElementById('concessions-container');
                const newConcession = `
                    <div class="concession-item flex space-x-4 mb-2">
                        <select name="concessions[${concessionIndex}][id]" class="concession-select w-full" required>
                            <option value="">Select a Concession</option>
                            @foreach ($concessions as $concession)
                                <option value="{{ $concession->id }}">{{ $concession->name }}</option>
                            @endforeach
                        </select>
                        <input type="number" name="concessions[${concessionIndex}][quantity]" class="w-20 border-gray-300 rounded-md"
                            placeholder="Qty" min="1" required>
                        <button type="button" class="remove-concession bg-red-500 text-white px-2 py-1 rounded">
                            &times;
                        </button>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', newConcession);
                concessionIndex++;
            });

            // Remove concession row
            document.getElementById('concessions-container').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-concession')) {
                    e.target.parentElement.remove();
                }
            });
        });
    </script>
</x-app-layout>
