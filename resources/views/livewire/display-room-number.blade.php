<div class=" overflow-auto grid grid-cols-10 gap-2" >
    @for ($i = 0; $i < 3; $i++)
        @for ($x = 0; $x < 10; $x++)
            <div
                class="p-2 w-32 h-32 rounded drop-shadow-lg bg-white flex flex-col m-2 justify-center items-center relative group">
                @php

                    $roomNumber = ($i + 1) * 100 + $x + 1;

                    $room = null;

                    foreach ($roomNumbers as $room) {
                        if ($room->room_number == $roomNumber) {
                            $room = $room;
                            break;
                        }
                        $room = null;
                    }
                @endphp

                @if ($room)
                    <div class="text-center">
                        <p class="font-bold">Room {{ $roomNumber }}</p>
                        <p class="text-xs rounded-full bg-green-600 text-white px-2 py-1">{{$room->room->RoomType}}</p>
                    </div>

                    <!-- Delete button, positioned to overlay the text -->
                    <button type="button"
                        class="absolute inset-0 flex justify-center items-center bg-cyan-500  text-white p-2 rounded opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                        Update Room
                    </button>
                @else
                    <div class="text-center">
                        <p class="font-bold">Room {{ $roomNumber }}</p>
                        <p  class="text-xs rounded-full bg-red-600 text-white px-2 py-1">Available Slot</p>
                    </div>
                    <button wire:click.prevent="viewModal({{ $roomNumber }})"
                        class="absolute inset-0 flex justify-center items-center bg-green-500  text-white p-2 rounded opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                        Set room
                    </button>
                @endif
            </div>
        @endfor
    @endfor


    @if ($displayRoomNumberModal)
        <div class="fixed z-50 inset-0">
            <div class="fixed inset-0 bg-gray-300 opacity-40 ">
            </div>
            <div class="bg-white rounded m-auto fixed inset-0 max-w-xl h-fit p-5 ">
                <div class="flex items-center justify-between  border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Set Room
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        wire:click.prevent="closeModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <div class="max-h-96 overflow-auto">

                    <form wire:submit.prevent="saveRoom">
                        @csrf

                        <label for="countries"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an
                            option</label>
                        <select wire:model="selectedRoom" id="countries"
                            class="mb-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                            <option value="">Select Room</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->RoomId }}">{{ $room->RoomType }}</option>
                            @endforeach
                        </select>

                        @if (session()->has('error'))
                            <div class="bg-red-300 rounded p-2">
                                <span class="text-red-700">
                                    {{ session('error') }}
                                </span>
                            </div>
                        @endif

                        @if (session()->has('success'))
                            <div class="bg-green-300 rounded p-2">
                                <span class="text-green-700">
                                    {{ session('success') }}
                                </span>
                            </div>
                        @endif

                        <div class="flex justify-end mt-2">
                            <button class="p-2 rounded bg-green-700 text-white " type="submit">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    @endif

    <div wire:loading>
        <x-loader />

    </div>

</div>
