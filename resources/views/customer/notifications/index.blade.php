<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-200">Booking Notifications</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
            @if ($notifications->isEmpty())
                <p>No new notifications.</p>
            @else
                <ul>
                    @foreach ($notifications as $note)
                        <li class="mb-4 p-4 border rounded bg-green-50">
                            ✅ Your booking for:
                            <strong>
                                {{ $note->space->bldg_name ?? '' }},
                                Floor {{ $note->space->bldg_floor_no }},
                                Lot {{ $note->space->lot_no }}
                            </strong>
                            has been <span class="font-bold text-green-700">confirmed</span>.
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout>
