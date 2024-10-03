<div class="bg-gray-50 rounded">
    <h5 class="mx-2 font-bold px-2 pt-2">Search</h5>
    <div class="relative mb-4 w-1/3 mx-3">

        <input type="text" wire:model.live.debounce.300ms = "search"
            class="bg-gray-100 text-gray-900 placeholder-gray-400 px-3 py-2  rounded-lg w-full outline-none focus:outline-none"
            placeholder="Search . . . ">
        <span class="absolute inset-y-0 right-0 flex items-center pr-3">
            <i class="fas fa-search text-gray-400"></i>
        </span>
    </div>

    <div class="w-full flex p-2 justify-center">
        <table class="w-full text-sm text-left rtl:text-right overflow-hidden">
            <thead class="text-xs uppercase bg-gray-100 ">
                <tr class="text-center">
                    <th class="py-2">ID</th>
                    <th class="py-2">Name</th>
                    <th class="py-2">Room Number</th>
                    <th class="py-2">Date</th>
                    <th class="py-2">Time</th>
                    <th class="py-2">Status</th>

                    <th class="py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($checkInOuts as $checkInOut)

                <tr class="text-center">
                    <td class="py-2">{{ $checkInOut->id }}</td>
                    <td class="py-2">{{ $checkInOut->guest->FirstName ?? '' ." " . $checkInOut->guest->LastName ?? '' }}</td>
                    <td class="py-2">{{ $checkInOut->reservation->room->RoomNumber ?? '' }}</td>
                    <td class="py-2">{{ $checkInOut->DateCreated }}</td>
                    <td class="py-2">{{ $checkInOut->TimeCreated }}</td>
                    <td class="py-2">{{ $checkInOut->Type }}</td>
                    <td class="py-2">
                        <a href="{{route('bookingDetails', $checkInOut->reservation->ReservationId)}}"
                            class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">View</a>

                    </td>

                @endforeach
            <tbody>

        </table>


    </div>



</div>
