<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Available Parking Spaces
        </h2>
    </x-slot>

    <div class="p-6">
        <a href="{{ route('available-parking-spaces.create') }}" class="inline-flex items-center px-5 py-3 bg-green-500 text-white font-bold text-base rounded shadow hover:bg-green-600 hover:shadow-lg transition mb-3">
            + Add Parking Space
        </a>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
        @endif

        <div class="hidden sm:block bg-white shadow rounded-lg p-4">
        @if($spaces->isEmpty())
            <p class="flex items-center justify-center">No available parking spaces.</p>
        @else

        <form method="GET" action="{{ route('available-parking-spaces.index') }}" class="mb-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search parking spaces..." class="form-input text-gray-800">
            <button type="submit" class="bg-gray-600 hover:bg-gray-800 rounded ml-3 px-4 py-2 text-white">Search</button>
        </form>

            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="px-4 py-2">Floor No</th>
                        <th class="px-4 py-2">Lot No</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($spaces as $space)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $space->bldg_floor_no }}</td>
                            <td class="px-4 py-2">{{ $space->lot_no }}</td>
                            <td class="px-4 py-2 capitalize">{{ $space->status }}</td>
                            <td class="flex px-4 py-2 space-x-2">
                                <a href="{{ route('available-parking-spaces.edit', $space) }}" class="text-white bg-blue-500 hover:bg-blue-700 rounded px-3 py-1">Edit</a>
                                <form action="{{ route('available-parking-spaces.destroy', $space) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white bg-red-500 hover:bg-red-700 rounded px-3 py-1">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $spaces->links() }}
        </div>
        <a href="{{ route('available_parking_spaces.pdf') }}" class="text-white bg-green-500 hover:bg-green-600 rounded px-2 py-2 flex items-center justify-center mt-5">Download PDF</a>
        @endif
    </div>
</x-app-layout>
