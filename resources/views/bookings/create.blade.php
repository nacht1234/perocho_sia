<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            New Booking
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <form method="POST" action="{{ route('bookings.store') }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-x-6 gap-y-6">
                        <div class="mb-4">
                            <label class="block">Customer</label>
                            <select name="customer_id" required class="w-full border px-3 py-2 rounded">
                                <option value="">-- Select Customer --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>{{ $customer->name }}</option>
                                @endforeach
                            </select>
                            @error('customer_id') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block">Available Parking Space</label>
                            <select name="available_parking_space_id" required class="w-full border px-3 py-2 rounded">
                                <option value="">-- Select Parking Space --</option>
                                @foreach ($spaces as $space)
                                    <option value="{{ $space->id }}" @selected(old('available_parking_space_id') == $space->id)>
                                        Floor {{ $space->bldg_floor_no }} - Lot {{ $space->lot_no }}
                                    </option>
                                @endforeach
                            </select>
                            @error('available_parking_space_id') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block">Car Brand</label>
                            <input type="text" name="car_brand" value="{{ old('car_brand') }}" required class="w-full border px-3 py-2 rounded">
                            @error('car_brand') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block">Car Model</label>
                            <input type="text" name="car_model" value="{{ old('car_model') }}" required class="w-full border px-3 py-2 rounded">
                            @error('car_model') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block">License Plate</label>
                            <input type="text" name="license_plate" value="{{ old('license_plate') }}" required class="w-full border px-3 py-2 rounded">
                            @error('license_plate') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="flex justify-center space-x-2 mt-6">
                        <button type="submit"
                            class="px-4 py-2 bg-green-500 text-black font-semibold rounded hover:bg-green-700">Save</button>
                        <a href="{{ route('available-parking-spaces.index') }}"
                            class="ml-3 text-black bg-red-500 hover:bg-red-700 font-semibold rounded px-4 py-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
