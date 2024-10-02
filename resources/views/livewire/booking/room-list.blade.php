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
                    <a href="{{ route('createBooking', $room->RoomId) }}"
                        class="h-24
                        @switch($room->RoomType)
                            @case('Single bed')
                                bg-cyan-200
                                @break
                            @case('Two single beds')
                                bg-violet-200
                                @break
                            @case('Two double beds')
                                bg-blue-200
                                @break
                            @case('Matrimonial')
                                bg-green-200
                                @break
                            @case('Family')
                                bg-orange-200
                                @break
                            @case('King size')
                                bg-red-200
                                @break
                            @default
                                bg-gray-200
                        @endswitch
                        items-center flex justify-center border-2 rounded shadow-lg translate hover:scale-105 duration-100 hover:shadow-xl">
                        {{ $room->RoomNumber }}
                    </a>
                    <div class="absolute top-1/2 left-full transform -translate-y-1/2 translate-x-2 w-96 mb-2 hidden group-hover:block z-50">
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                            <div class="h-52 bg-gray-200 flex items-center justify-center">
                                @if ($room->roomPictures->isNotEmpty())
                                    <img src="data:image/png;base64,{{  base64_encode($room->roomPictures->first()->PictureFile )}}" alt="{{ $room->RoomType }}" class="object-cover h-full w-full">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-500">No Image Available</div>
                                @endif
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between">
                                    <div class="font-bold text-lg">{{ $room->RoomType }}</div>
                                    <div class="text-red-600">{{ $room->RoomStatus }}</div>
                                </div>
                                <div class="text-sm text-gray-700 mt-1">{{ $room->RoomDescription }}</div>
                                <div class="mt-2">
                                    <div class="flex justify-between">
                                        <div class="font-bold">Price:</div>
                                        <div class="text-red-600">{{ $room->RoomPrice }}</div>
                                    </div>
                                    <div class="text-sm text-gray-600">Room Capacity: {{ $room->Capacity }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
