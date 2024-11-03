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

    <div class="w-full flex p-2 justify-center rounded-lg drop-shadow">
        <table class="w-full h-full">
            <thead class="text-xs uppercase bg-gray-50">
                <tr class="text-center">
                    <th scope="col" class="px-2 py-3">Booking ID</th>
                    <th scope="col" class="px-2 py-3">Full Name</th>
                    <th scope="col" class="px-2 py-3">Room</th>
                    <th scope="col" class="px-2 py-3">Booking Date</th>
                    <th scope="col" class="px-2 py-3">Check In</th>
                    <th scope="col" class="px-2 py-3">Check Out</th>
                    <th scope="col" class="px-2 py-3">Status</th>
                    <th scope="col" class="px-2 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    use Carbon\Carbon;
                @endphp
                @foreach ($bookings as $booking)
                    <tr class="bg-white border-b text-xs text-center">

                        <td class="px-2 py-3">{{ $booking->ReservationId }}</td>
                        <td class="px-2 py-3">
                            {{ $booking->guest->FirstName . ' ' . $booking->guest->MiddleName . ' ' . $booking->guest->LastName }}
                        </td>
                        <td class="py-3 px-2">
                            {{ $booking->roomNumber->room->RoomType . ' - #' . $booking->roomNumber->room_number }}</td>
                        <td class="py-3 px-2">{{ Carbon::parse($booking->DateCreated)->format('F j, Y') }}</td>
                        <td class="py-3 px-2">{{ Carbon::parse($booking->DateCheckIn)->format('F j, Y') }}</td>
                        <td class="py-3 px-2">{{ Carbon::parse($booking->DateCheckOut)->format('F j, Y') }}</td>

                        <td class="py-3 px-2">
                            @if ($booking->Status == 'Pending')
                                <span
                                    class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded-full">{{ $booking->Status }}</span>
                            @endif
                            @if ($booking->Status == 'Booked')
                                <span
                                    class="bg-blue-200 text-blue-800 px-2 py-1 rounded-full">{{ $booking->Status }}</span>
                            @endif
                            @if ($booking->Status == 'Reserved')
                                <span
                                    class="bg-green-200 text-green-800 px-2 py-1 rounded-full">{{ $booking->Status }}</span>
                            @endif


                            @if ($booking->Status == 'Checked In')
                                <span
                                    class="bg-green-200 text-green-800 px-2 py-1 rounded-full">{{ $booking->Status }}</span>
                            @endif
                            @if ($booking->Status == 'Checked Out')
                                <span
                                    class="bg-blue-200 text-blue-800 px-2 py-1 rounded-full">{{ $booking->Status }}</span>
                            @endif
                            @if ($booking->Status == 'Cancelled')
                                <span
                                    class="bg-red-200 text-red-800 px-2 py-1 rounded-full">{{ $booking->Status }}</span>
                            @endif
                            @if ($booking->Status == 'No Show')
                                <span
                                    class="bg-gray-200 text-gray-800 px-2 py-1 rounded-full">{{ $booking->Status }}</span>
                            @endif


                        </td>
                        <td class="py-3 px-2">

                            <a href="{{ route('bookingDetails', $booking->ReservationId) }}"
                                class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">View</a>

                        </td>
                @endforeach
            </tbody>
        </table>


    </div>
    <div class="py-4 px-3">
        <div class="flex justify-between items-center">
            <div class="flex-1">
                <p class="text-sm text-gray-700 dark:text-gray-400">
                    Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }}
                    rooms
                </p>
            </div>
            <div class="flex items-center">
                @if ($bookings->onFirstPage())
                    <span class="px-2 py-1 text-gray-500 bg-gray-200 rounded-l cursor-not-allowed">Previous</span>
                @else
                    <a href="{{ $bookings->previousPageUrl() }}"
                        class="px-2 py-1 bg-cyan-500 text-white rounded-l hover:bg-cyan-600">Previous</a>
                @endif

                @if ($bookings->hasMorePages())
                    <a href="{{ $bookings->nextPageUrl() }}"
                        class="px-2 py-1 bg-cyan-500 text-white rounded-r hover:bg-cyan-600">Next</a>
                @else
                    <span class="px-2 py-1 text-gray-500 bg-gray-200 rounded-r cursor-not-allowed">Next</span>
                @endif
            </div>
        </div>


    </div>


</div>
