<div class="bg-gray-50 rounded">
    <h5 class="mx-2 font-bold px-2 pt-2 mb-2">Room</h5>
    <div class="relative mb-4 w-1/3 mx-3">

        <input type="text" wire:model.live.debounce.300ms = "search"
            class="bg-gray-100 text-gray-900 placeholder-gray-400 px-3 py-2  rounded-lg w-full outline-none focus:outline-none"
            placeholder="Search . . . ">
        <span class="absolute inset-y-0 right-0 flex items-center pr-3">
            <i class="fas fa-search text-gray-400"></i>
        </span>
    </div>

    <div class="flex p-2 justify-center">

        <div class="grid grid-cols-2 gap-x-5 gap-y-4 overflow-auto  p-2">
            @foreach ($rooms as $room)
                <div
                    class=" w-full min-w-full max-w-full
                    shadow rounded-lg
                 bg-slate-50 grid grid-cols-4  p-1 max-h-40 min-h-40
                 ">
                    <div class="col-span-1 rounded-lg overflow-hidden">
                        @php
                            $topImage = $room->roomPictures->first();
                        @endphp
                        @if ($topImage == null)
                            <img class="h-full bg-slate-200"
                                src="https://developers.elementor.com/docs/assets/img/elementor-placeholder-image.png"
                                alt="">
                        @else
                            <img class="h-full bg-slate-200"
                                src="data:image/png;base64,{{ base64_encode($topImage->PictureFile) }}" alt="">
                        @endif



                    </div>

                    <div class="col-span-3 p-2">
                        <div class="flex justify-between items-center">
                            <div>
                                <h1 class="text-base font-bold">{{ $room->RoomType }}</h1>

                            </div>
                            <div class="flex justify-end">
                                <div>
                                    <a href="{{ route('viewRoom', Crypt::encrypt($room->RoomId)) }}"
                                        class="block px-2 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-xs"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                </div>
                                <div>
                                    <a href="{{ route('updateRoom', Crypt::encrypt($room->RoomId)) }}"
                                        class=" text-xs block px-2 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                </div>
                                <div>
                                    <button data-modal-target="popup-modal-{{ $room->RoomId }}"
                                        data-modal-toggle="popup-modal-{{ $room->RoomId }}"
                                        class="w-full block px-2 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-xs"
                                        type="button">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="grid grid-cols-1">
                            <div class="h-20 overflow-hidden">
                                <p class="text-xs ">{{ $room->Description }}</p>
                            </div>


                            <div class="grid grid-cols-3 text-xs  bottom-1">
                                <div>
                                    <span class="font-bold">Price:</span> {{ $room->RoomPrice }}
                                </div>

                                <div>
                                    <span class="font-bold">Capacity:</span> {{ $room->Capacity }}
                                </div>
                                <div>
                                    <span class="font-bold">Room Number:</span> {{ $room->RoomNumber }}</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div id="popup-modal-{{ $room->RoomId }}" tabindex="-1"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <button type="button"
                                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="popup-modal-{{ $room->RoomId }}">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-4 md:p-5 text-center">
                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure
                                    you want to delete this room?</h3>
                                <button wire:click="delete({{ $room->RoomId }})"
                                    data-modal-hide="popup-modal-{{ $room->RoomId }}" type="button"
                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                    Yes, I'm sure
                                </button>
                                <button data-modal-hide="popup-modal-{{ $room->RoomId }}" type="button"
                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                                    cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <div class="py-4 px-3">
        <div class="flex justify-between items-center">
            <div class="flex-1">
                <p class="text-sm text-gray-700 dark:text-gray-400">
                    Showing {{ $rooms->firstItem() }} to {{ $rooms->lastItem() }} of {{ $rooms->total() }} rooms
                </p>
            </div>
            <div class="flex items-center">
                @if ($rooms->onFirstPage())
                    <span class="px-2 py-1 text-gray-500 bg-gray-200 rounded-l cursor-not-allowed"><i
                            class="fas fa-long-arrow-alt-left"></i></span>
                @else
                    <a href="{{ $rooms->previousPageUrl() }}"
                        class="px-2 py-1 bg-cyan-500 text-white rounded-l hover:bg-cyan-600"><i
                            class="fas fa-long-arrow-alt-left"></i></a>
                @endif

                @if ($rooms->hasMorePages())
                    <a href="{{ $rooms->nextPageUrl() }}"
                        class="px-2 py-1 bg-cyan-500 text-white rounded-r hover:bg-cyan-600"><i
                            class="fas fa-long-arrow-alt-right"></i></a>
                @else
                    <span class="px-2 py-1 text-gray-500 bg-gray-200 rounded-r cursor-not-allowed"><i
                            class="fas fa-long-arrow-alt-right"></i></span>
                @endif
            </div>
        </div>
    </div>
</div>
