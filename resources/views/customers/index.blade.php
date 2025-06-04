<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Customers</h2>
    </x-slot>

    <div class="p-6">
        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 text-red-600">{{ session('error') }}</div>
        @endif

        @if($customers->isEmpty())
            <p class="flex items-center justify-center">No customers signed up yet.</p>
        @else
        <form method="GET" action="{{ route('customers.index') }}" class="mb-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search customers..." class="form-input text-gray-800">
            <button type="submit" class="bg-gray-600 hover:bg-gray-800 rounded ml-3 px-4 py-2 text-white">Search</button>
        </form>

        <div class="hidden sm:block bg-white shadow rounded-lg p-4">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Age</th>
                        <th class="px-4 py-2">Gender</th>
                        <th class="px-4 py-2">Phone</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $customer->name }}</td>
                            <td class="px-4 py-2">{{ $customer->age }}</td>
                            <td class="px-4 py-2">{{ $customer->gender }}</td>
                            <td class="px-4 py-2">{{ $customer->phone }}</td>
                            <td class="flex px-4 py-2 space-x-2">
                                <a href="{{ route('customers.edit', $customer) }}" class="text-white bg-blue-500 hover:bg-blue-700 rounded px-3 py-1">Edit</a>
                                <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
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
            {{ $customers->links() }}
        </div>
        <a href="{{ route('customers.pdf') }}" class="text-white bg-green-500 hover:bg-green-600 rounded px-2 py-2 flex items-center justify-center mt-5">Download PDF</a>
        @endif
    </div>
</x-app-layout>