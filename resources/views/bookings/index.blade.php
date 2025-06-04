<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Booking
        </h2>
    </x-slot>

    <div class="p-6">

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" action="{{ route('bookings.index') }}" class="mb-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search bookings..." class="form-input text-gray-800">
            <button type="submit" class="bg-gray-600 hover:bg-gray-800 rounded ml-3 px-4 py-2 text-white">Search</button>
        </form>

        <div class="hidden sm:block bg-white shadow rounded-lg p-4">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="px-4 py-2">Customer</th>
                        <th class="px-4 py-2">Car</th>
                        <th class="px-4 py-2">Plate</th>
                        <th class="px-4 py-2">Floor</th>
                        <th class="px-4 py-2">Lot No</th>
                        <th class="px-4 py-2">Booking Date</th>
                        <th class="px-4 py-2">Confirmed By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $booking->customer->name }}</td>
                            <td class="px-4 py-2">{{ $booking->car_brand }} {{ $booking->car_model }}</td>
                            <td class="px-4 py-2">{{ $booking->license_plate }}</td>
                            <td class="px-4 py-2">{{ $booking->space->bldg_floor_no }}</td>
                            <td class="px-4 py-2">{{ $booking->space->lot_no }}</td>
                            <td class="px-4 py-2">{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-2">
                                @if($booking->confirmedBy)
                                    {{ $booking->confirmedBy->name }}
                                @else
                                    Not confirmed yet
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
        <a href="{{ route('bookings.pdf') }}" class="text-white bg-green-500 hover:bg-green-600 rounded px-2 py-2 flex items-center justify-center">Download PDF</a>
    </div>
</x-app-layout>
