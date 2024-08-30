<div class="space-y-4">

    @php
        $groupedRooms = $rooms->groupBy(function ($room) {
            return floor($room->RoomNumber / 100) * 100;
        });
    @endphp

    @foreach ($groupedRooms as $group => $room)
        <div class="grid grid-cols-12 gap-2 m-2">

            @foreach ($room as $room)
                <div class="relative group">

                    <a href="{{ route('booking-details', Crypt::encrypt($room->RoomId)) }}"
                        class="h-24 bg-cyan-200 items-center flex justify-center border-2 border-red-600 rounded shadow-lg translate hover:scale-105 duration-100 hover:shadow-xl">
                        {{ $room->RoomNumber }}
                    </a>
                    <div class="absolute bottom-full left-1/2 transform -translate-x-2/3 w-96 mb-2 hidden group-hover:block">

                        <div class="bg-gray-800 text-white text-xs rounded py-1 px-2">
                            <div class="h-32">
                                img
                            </div>
                            Booking details for item {{ $room->RoomType }}
                        </div>
                        <div class="w-2 h-2 bg-gray-800 transform rotate-45 mx-auto mt-1"></div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
