<div class="bg-gray-50 rounded">
    <h5 class="mx-2 font-bold px-2 pt-2">User Information</h5>
    <div class="relative mb-4 w-1/3 mx-3">

        <input type="text" wire:model.live.debounce.300ms = "search"
            class="bg-gray-100 text-gray-900 placeholder-gray-400 px-3 py-2  rounded-lg w-full outline-none focus:outline-none"
            placeholder="Search . . . ">
        <span class="absolute inset-y-0 right-0 flex items-center pr-3">
            <i class="fas fa-search text-gray-400"></i>
        </span>
    </div>

    <div class="w-full flex p-2 justify-center rounded-lg drop-shadow">
        <table class="w-full h-full">
            <thead class="text-xs uppercase bg-gray-50">
                <tr class="text-center">
                    <th scope="col" class="px-2 py-3">No</th>
                    <th scope="col" class="px-2 py-3">Username</th>
                    <th scope="col" class="px-2 py-3">Full Name</th>
                    <th scope="col" class="px-2 py-3">Position</th>
                    <th scope="col" class="px-2 py-3">Email</th>
                    <th scope="col" class="px-2 py-3">Contact Number</th>
                    <th scope="col" class="px-2 py-3">Status</th>
                    <th scope="col" class="px-2 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="bg-white border-b text-xs text-center">
                        <td class="px-2 py-3">{{ $user->EmployeeId }}</td>
                        <td class="px-2 py-3">{{ $user->Username }}</td>
                        <td class="px-2 py-3">
                            {{ $user->FirstName . (empty($user->MiddleName) ? ' ' : ' ' . $user->MiddleName[0] . '. ') . $user->LastName }}
                        </td>
                        <td class="px-2 py-3">{{ $user->Position }}</td>
                        <td class="px-2 py-3">{{ utf8_encode($user->email) }}</td>
                        <td class="px-2 py-3">{{ $user->ContactNumber }}</td>
                        <td class="px-2 py-3">
                            @if ($user->Status == 'Active')
                                <span
                                    class="px-2 py-1 bg-green-500 text-white rounded-full text-xs">{{ $user->Status }}</span>
                            @else
                                <span
                                    class="px-2 py-1 bg-red-500 text-white rounded-full text-xs">{{ $user->Status }}</span>
                            @endif
                        <td class="px-2 py-3">
                            <button x-data
                                x-on:click="$dispatch('open-dropdown', { name: 'dropdown-{{ $user->EmployeeId }}' })"
                                class="px-4 py-2 rounded-full text-cyan-500 hover:bg-cyan-100" type="button">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>

                            <x-dropdown name="dropdown-{{ $user->EmployeeId }}">
                                @slot('body')
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                        <li>
                                            <a href="{{ route('updateUser', $user->EmployeeId) }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Update</a>
                                        </li>
                                        <li>
                                            <button wire:click="changeStatus({{ $user->EmployeeId }})"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-center w-full">

                                                @if ($user->Status == 'Active')
                                                    Deactivate
                                                @else
                                                    Activate
                                                @endif
                                            </button>
                                        </li>
                                        <li>
                                            <button x-on:click="$dispatch('open-modal', {name: 'delete-modal-{{ $user->EmployeeId }}'})"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full">Delete</button>
                                        </li>

                                    </ul>
                                @endslot
                            </x-dropdown>
                        </td>


                        <x-modal title="Delete User" name="delete-modal-{{ $user->EmployeeId }}">

                            @slot('body')
                                <div class="p-4 md:p-5 text-center">
                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you
                                        sure
                                        you want to delete this user?</h3>
                                    <button wire:click="delete({{ $user->EmployeeId}})" type="button"
                                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                        Yes, I'm sure
                                    </button>
                                    <button
                                        x-on:click="$dispatch('close-modal', {name: 'delete-modal-{{ $user->EmployeeId}}'})"
                                        type="button"
                                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                                        cancel</button>
                                </div>
                            @endslot
                        </x-modal>
                @endforeach
            </tbody>
        </table>


    </div>


    <div class="py-4 px-3">
        <div class="flex justify-between items-center">
            <div class="flex-1">
                <p class="text-sm text-gray-700 dark:text-gray-400">
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} User
                </p>
            </div>
            <div class="flex items-center">
                @if ($users->onFirstPage())
                    <span class="px-2 py-1 text-gray-500 bg-gray-200 rounded-l cursor-not-allowed">Previous</span>
                @else
                    <a href="{{ $users->previousPageUrl() }}"
                        class="px-2 py-1 bg-cyan-500 text-white rounded-l hover:bg-cyan-600">Previous</a>
                @endif

                @if ($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}"
                        class="px-2 py-1 bg-cyan-500 text-white rounded-r hover:bg-cyan-600">Next</a>
                @else
                    <span class="px-2 py-1 text-gray-500 bg-gray-200 rounded-r cursor-not-allowed">Next</span>
                @endif
            </div>
        </div>


    </div>






</div>
