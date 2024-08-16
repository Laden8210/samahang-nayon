<div class="bg-gray-50 rounded">
    <h5 class="mx-2 font-bold px-2 pt-2">Search</h5>
    <div class="relative mb-4 w-1/3 mx-3">

        <input type="text" wire:model.live.debounce.300ms = "search"
            class="bg-gray-100 text-gray-900 placeholder-gray-400 px-2 py-1  w-full outline-none focus:outline-none"
            placeholder="Search . . . ">
        <span class="absolute inset-y-0 right-0 flex items-center pr-3">
            <i class="fas fa-search text-gray-400"></i>
        </span>
    </div>

    <div class="w-full flex p-2 justify-center">
        <table class="w-full text-sm text-left rtl:text-right overflow-hidden">
            <thead class="text-xs uppercase bg-gray-100 ">
                <tr class="text-center">
                    <th class="py-2">Booking ID</th>
                    <th class="py-2">Full Name</th>
                    <th class="py-2">Room</th>
                    <th class="py-2">Check In</th>
                    <th class="py-2">Check Out</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr class="text-center">
                        <td class="py-3">{{ $user->EmplooyeeId }}</td>
                        <td class="py-3">{{ $user->EmplooyeeId }}</td>
                        <td class="py-3">{{ $user->EmplooyeeId }}</td>
                        <td class="py-3">{{ $user->EmplooyeeId }}</td>
                        <td class="py-3">{{ $user->EmplooyeeId }}</td>
                @endforeach
            </tbody>
        </table>


    </div>
    {{-- <div class="py-4 px-3">
        <div class="flex justify-between items-center">
            <div class="flex-1">
                <p class="text-sm text-gray-700 dark:text-gray-400">
                    Showing {{ $rooms->firstItem() }} to {{ $rooms->lastItem() }} of {{ $rooms->total() }} rooms
                </p>
            </div>
            <div class="flex items-center">
                @if ($rooms->onFirstPage())
                <span class="px-2 py-1 text-gray-500 bg-gray-200 rounded-l cursor-not-allowed">Previous</span>
                @else
                <a href="{{ $rooms->previousPageUrl() }}" class="px-2 py-1 bg-cyan-500 text-white rounded-l hover:bg-cyan-600">Previous</a>
                @endif

                @if ($rooms->hasMorePages())
                <a href="{{ $rooms->nextPageUrl() }}" class="px-2 py-1 bg-cyan-500 text-white rounded-r hover:bg-cyan-600">Next</a>
                @else
                <span class="px-2 py-1 text-gray-500 bg-gray-200 rounded-r cursor-not-allowed">Next</span>
                @endif
            </div>
        </div>


    </div> --}}


</div>
