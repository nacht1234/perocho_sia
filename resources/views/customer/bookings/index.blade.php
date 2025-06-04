<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            My Bookings
        </h2>
    </x-slot>
    <div class="p-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
        @endif

        <div class="hidden sm:block bg-white shadow rounded-lg p-4">
            @if($bookings->isEmpty())
                <p class="flex items-center justify-center">No bookings made.</p>
            @else
            <form method="GET" action="{{ route('customer.bookings.index') }}" class="mb-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search bookings..." class="form-input text-gray-800">
                <button type="submit" class="bg-gray-600 hover:bg-gray-800 rounded ml-3 px-4 py-2 text-white">Search</button>
            </form>
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="px-4 py-2">Floor</th>
                        <th class="px-4 py-2">Lot</th>
                        <th class="px-4 py-2">Car</th>
                        <th class="px-4 py-2">Plate</th>
                        <th class="px-4 py-2">Booking Date</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $booking->space->bldg_floor_no }}</td>
                            <td class="px-4 py-2">{{ $booking->space->lot_no }}</td>
                            <td class="px-4 py-2">{{ $booking->car_brand }} {{ $booking->car_model }}</td>
                            <td class="px-4 py-2">{{ $booking->license_plate }}</td>
                            <td class="px-4 py-2">{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-2 flex space-x-2">
                                <form method="POST" action="{{ route('customer.bookings.destroy', $booking->id) }}">
                                    @csrf
                                    @method('DELETE')

                                    @if (!$booking->is_confirmed)
                                        <button type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700"
                                            onclick="return confirm('Are you sure you want to cancel this booking?')">
                                            Cancel
                                        </button>
                                    @else
                                        <button type="submit"
                                            class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-700"
                                            onclick="return confirm('Unoccupy this parking space?')">
                                            Unoccupy
                                        </button>
                                    @endif
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
        <a href="{{ route('customer.bookings.pdf') }}" class="text-white bg-green-500 hover:bg-green-600 rounded px-2 py-2 flex items-center justify-center mt-5">Download PDF</a>
        @endif
</x-app-layout>
