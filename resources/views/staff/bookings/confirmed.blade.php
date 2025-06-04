<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Confirmed Bookings
        </h2>
    </x-slot>

    <div class="py-6">
        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 text-red-600">{{ session('error') }}</div>
        @endif

        @if($bookings->isEmpty())
            <p class="flex items-center justify-center">No bookings confirmed.</p>
        @else

        <form method="GET" action="{{ route('staff.bookings.index') }}" class="mb-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search bookings..." class="form-input text-gray-800">
            <button type="submit" class="bg-gray-600 hover:bg-gray-800 rounded ml-3 px-4 py-2 text-white">Search</button>
        </form>

        <div class="hidden sm:block bg-white shadow rounded-lg p-4">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="px-4 py-2">Booking ID</th>
                        <th class="px-4 py-2">Customer Name</th>
                        <th class="px-4 py-2">Parking Space</th>
                        <th class="px-4 py-2">License Plate</th>
                        <th class="px-4 py-2">Booked At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $booking->id }}</td>
                            <td class="px-4 py-2">{{ $booking->customer->name }}</td>
                            <td class="px-4 py-2">Floor {{ $booking->space->bldg_floor_no }} - Lot {{ $booking->space->lot_no }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $booking->license_plate }}</td>
                            <td class="px-4 py-2">{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
        <div class="mt-4">
                {{ $bookings->links() }}
        </div>
        <a href="{{ route('staff.bookings.pdf') }}" class="text-white bg-green-500 hover:bg-green-600 rounded px-2 py-2 flex items-center justify-center mt-5">Download PDF</a>
    </div>
</x-app-layout>
