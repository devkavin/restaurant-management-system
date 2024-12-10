<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Concession') }}
        </h2>
    </x-slot>

    <x-alert />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Edit Form -->
                    <form method="POST" action="{{ route('concessions.update', $concession) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Important to specify PUT method for updates -->

                        <div class="mt-4">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                value="{{ old('name', $concession->name) }}" required autofocus />
                            @error('name')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" class="block mt-1 w-full" name="description">{{ old('description', $concession->description) }}</textarea>
                            @error('description')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <x-input-label for="image" :value="__('Image')" />
                            <input id="image" class="block mt-1 w-full" type="file" name="image" />
                            @error('image')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-gray-600">Leave blank if you don't want to change the image.</p>
                            @if ($concession->image)
                                <div class="mt-2">
                                    <p>Current Image:</p>
                                    <img src="{{ Storage::url($concession->image) }}" alt="{{ $concession->name }}"
                                        class="w-40 h-40 object-cover rounded">
                                </div>
                            @endif
                        </div>

                        <div class="mt-4">
                            <x-input-label for="price" :value="__('Price')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" min="0"
                                step="1.00" name="price" value="{{ old('price', $concession->price) }}" required />
                            @error('price')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Update') }}
                            </x-primary-button>

                            <x-primary-button class="ml-4">
                                <a href="{{ route('concessions.index') }}">
                                    {{ __('Cancel') }}
                                </a>
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
