<div class="bg-gray-50 rounded">
    <h5 class="mx-2 font-bold px-2 pt-2">Room</h5>
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
                    <th class="py-2">No</th>
                    <th class="py-2">TYPE</th>
                    <th class="py-2">Description</th>
                    <th class="py-2">Capacity</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rooms as $room)
                    <tr class="text-center">
                        <td class="py-3">{{ $room->number }}</td>
                        <td class="py-3">{{ $room->type }}</td>
                        <td class="py-3">{{ $room->description }}</td>
                        <td class="py-3">{{ $room->capacity }}</td>
                        <td class="pyr-3">
                            <span class="rounded-full bg-slate-300 text-cyan-500 px-2 py-1">{{ $room->status }}</span>
                        </td>
                        <td class="py-3">
                            <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown-{{ $user->personal_id }}"
                                class="px-4 py-2 rounded-full text-cyan-500 hover:bg-cyan-100" type="button">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>

                            <!-- Dropdown menu -->
                            <div id="dropdown-{{ $user->personal_id }}"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownDefaultButton">
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Update</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Deactivate</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</a>
                                    </li>

                                </ul>
                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


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
                    <span class="px-2 py-1 text-gray-500 bg-gray-200 rounded-l cursor-not-allowed">Previous</span>
                @else
                    <a href="{{ $rooms->previousPageUrl() }}"
                        class="px-2 py-1 bg-cyan-500 text-white rounded-l hover:bg-cyan-600">Previous</a>
                @endif

                @if ($rooms->hasMorePages())
                    <a href="{{ $rooms->nextPageUrl() }}"
                        class="px-2 py-1 bg-cyan-500 text-white rounded-r hover:bg-cyan-600">Next</a>
                @else
                    <span class="px-2 py-1 text-gray-500 bg-gray-200 rounded-r cursor-not-allowed">Next</span>
                @endif
            </div>
        </div>


    </div>


</div>
