<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Parking Space
        </h2>
    </x-slot>

    <div class="py-6">
        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 text-red-600">{{ session('error') }}</div>
        @endif

        @if($space->isEmpty())
            <p class="flex items-center justify-center">No available parking spaces.</p>
        @else
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <form method="POST" action="{{ route('available-parking-spaces.update', $available_parking_space) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-x-6 gap-y-6">
                        <div class="mb-4">
                            <label class="block">Building Floor No</label>
                            <input type="text" name="bldg_floor_no" value="{{ old('bldg_floor_no', $available_parking_space->bldg_floor_no) }}" required class="w-full border px-3 py-2 rounded" />
                            @error('bldg_floor_no') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block">Lot No</label>
                            <input type="text" name="lot_no" value="{{ old('lot_no', $available_parking_space->lot_no) }}" required class="w-full border px-3 py-2 rounded" />
                            @error('lot_no') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block">Status</label>
                            <select name="status" class="w-full border px-3 py-2 rounded">
                                <option value="available" @selected(old('status', $available_parking_space->status) == 'available')>Available</option>
                                <option value="booked" @selected(old('status', $available_parking_space->status) == 'booked')>Booked</option>
                            </select>
                            @error('status') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="flex justify-center space-x-2 mt-6">
                        <button type="submit"
                            class="px-4 py-2 bg-green-500 text-black font-semibold rounded hover:bg-green-700">Update</button>
                        <a href="{{ route('available-parking-spaces.index') }}"
                            class="ml-3 text-black bg-red-500 hover:bg-red-700 font-semibold rounded px-4 py-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
