<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="mt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="hidden sm:block bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-left text-gray-700">
                            <th class="px-4 py-2 w-1/4">Name</th>
                            <th class="px-4 py-2 w-1/4">Email</th>
                            <th class="px-4 py-2 w-1/2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="border-b">
                                <td class="px-4 py-2 break-words max-w-xs">{{ $user->name }}</td>
                                <td class="px-4 py-2 break-words max-w-xs">{{ $user->email }}</td>
                                <td class="px-4 py-2">
                                    <form action="{{ route('users.updateRole', $user->id) }}" method="POST" class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <select name="role_id" class="border rounded px-8 py-1 w-full sm:w-auto">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" @if($user->roles->contains('id', $role->id)) selected @endif>
                                                    {{ ucfirst($role->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded text-sm hover:bg-blue-700">
                                            Update Role
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-2 text-center text-gray-500">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="block sm:hidden space-y-4">
                @forelse ($users as $user)
                    <div class="bg-white shadow rounded p-4">
                        <p class="text-sm"><strong>Name:</strong> {{ $user->name }}</p>
                        <p class="text-sm"><strong>Email:</strong> {{ $user->email }}</p>
                        <form action="{{ route('users.updateRole', $user->id) }}" method="POST" class="mt-3">
                            @csrf
                            @method('PUT')
                            <select name="role_id" class="border rounded w-full mb-2 px-2 py-1 text-sm">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" @if($user->roles->contains('id', $role->id)) selected @endif>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="w-full bg-blue-500 text-white py-1 rounded hover:bg-blue-700 text-sm">
                                Update Role
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="text-center text-gray-500">No users found.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
