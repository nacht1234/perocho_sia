<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Pending Bookings</h2>
    </x-slot>

    <div class="py-6">
        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 text-red-600">{{ session('error') }}</div>
        @endif

        @if($bookings->isEmpty())
            <p class="flex items-center justify-center">No pending bookings to confirm.</p>
        @else

        <form method="GET" action="{{ route('available-parking-spaces.index') }}" class="mb-4">
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
                        <th class="px-4 py-2">Booked At</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $booking->id }}</td>
                            <td class="px-4 py-2">{{ $booking->customer->name }}</td>
                            <td class="px-4 py-2">Floor {{ $booking->space->bldg_floor_no }} - Lot {{ $booking->space->lot_no }}</td>
                            <td class="px-4 py-2">{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                            <td class="flex px-4 py-2 space-x-2">
                                <form method="POST" action="{{ route('staff.bookings.confirm', $booking) }}">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                        Confirm
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</x-app-layout>