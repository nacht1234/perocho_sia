<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ isset($customer) ? 'Edit' : 'Create' }} Customer</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <form method="POST" action="{{ route('customers.store') }}">
                    @csrf
                    @if(isset($customer)) @method('PUT') @endif
                    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-x-6 gap-y-6">
                        <div class="mb-4">
                            <label class="block">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="w-full border px-3 py-2 rounded" />
                            @error('name') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block">Age</label>
                            <input type="text" name="age" value="{{ old('age') }}" required class="w-full border px-3 py-2 rounded" />
                            @error('age') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block">Gender</label>
                            <select name="gender" class="w-full border px-3 py-2 rounded">
                                <option value="male" @selected(old('gender') == 'male')>Male</option>
                                <option value="female" @selected(old('gender') == 'female')>Female</option>
                                <option value="other" @selected(old('gender') == 'other')>Other</option>
                            </select>
                            @error('gender') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full border px-3 py-2 rounded" />
                            @error('phone') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="flex justify-center space-x-2 mt-6">
                        <button type="submit"
                            class="px-4 py-2 bg-green-500 text-black font-semibold rounded hover:bg-green-700">Save</button>
                        <a href="{{ route('customers.index') }}"
                            class="ml-3 text-black bg-red-500 hover:bg-red-700 font-semibold rounded px-4 py-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>