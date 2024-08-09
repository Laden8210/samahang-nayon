<div>

    <form wire:submit.prevent="createRoom">

        <div class="justify-between flex p-1">
            <h1 class="text-2xl font-bold p-2">Room</h1>
            <div class="p-2">
                <button type="button" onclick="document.getElementById('roomModal').style.display = 'block';"
                    class="bg-red-400 font-medium text-white px-2 py-1 rounded ">
                    Cancel
                </button>
                <button type="submit" class="bg-cyan-400 font-medium text-white px-2 py-1 rounded ">
                    Create
                </button>
            </div>
        </div>

        @csrf

        <div class="flex justify-between ">
            <div class="p-2 bg-white rounded w-2/3 shadow mx-2">
                <div class="flex justify-between p-2">
                    <h4 class="text-cyan-500 font-bold">Room Information</h4>
                </div>

                <div class="flex justify-normal p-2 w-full">

                    <div class="w-1/2 mx-2">
                        <x-combobox name="roomType" model="roomType" placeholder="Room Type" :options="['das', 'dasd']" />

                        @error('roomType')
                            <p class="text-red-500 text-xs italic mt-1"><i
                                    class="fas fa-exclamation-circle"></i></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="w-1/2 mx-2">
                        <x-combobox name="capacity" model="capacity" placeholder="Capacity" :options="[1, 2, 3, 4, 5, 6, 7, 8, 9, 10]" />

                        @error('capacity')
                            <p class="text-red-500 text-xs italic mt-1"><i
                                    class="fas fa-exclamation-circle"></i></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>


                <div class="flex justify-normal p-2 w-full">

                    <div class="w-1/2 mx-2">
                        <x-text-field1 name="room_rate" placeholder="Room Rate" model="rate" />
                        @error('rate')
                            <p class="text-red-500 text-xs italic mt-1"><i
                                    class="fas fa-exclamation-circle"></i></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="w-1/2 mx-2">

                        <x-text-field1 name="room_number" placeholder="Room Number" model="roomNumber" />

                        @error('roomNumber')
                            <p class="text-red-500 text-xs italic mt-1"><i
                                    class="fas fa-exclamation-circle"></i></i>{{ $message }}
                            </p>
                        @enderror

                    </div>
                </div>

                <div class="mx-4">

                    <x-text-area name="description" model="description" placeholder="Description" />
                    @error('description')
                        <p class="text-red-500 text-xs italic mt-1"><i
                                class="fas fa-exclamation-circle"></i></i>{{ $message }}
                        </p>
                    @enderror

                </div>
            </div>

            <div class="w-1/3 rounded shadow p-2 mx-2 bg-white">

                <div class="mt-4 flex justify-start px-2">
                    <h4 class="text-cyan-500 font-bold">Media</h4>
                    <h5 class="px-1">(Image)</h5>
                </div>
                <div class="mt-1">
                    <div class="flex justify-around">
                        <div class="rounded border-1 border-slate-600 h-40 w-full bg-slate-100 m-2">
                            <label for="uploadFile"
                                class="bg-white text-gray-500 font-semibold text-base rounded max-w-md h-full flex flex-col items-center justify-center cursor-pointer border-2 border-gray-300 border-dashed mx-auto font-[sans-serif]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-11 mb-2 fill-gray-500"
                                    viewBox="0 0 32 32">
                                    <path
                                        d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956z"
                                        data-original="#000000" />
                                    <path
                                        d="M20.293 19.707a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z"
                                        data-original="#000000" />
                                </svg>
                                Upload files
                                <input type="file" id="uploadFile" class="hidden" multiple />
                            </label>

                        </div>
                    </div>
                </div>

                <div class="p-3">
                    <p class="text-gray-400 font-medium text-xs">Uploading Image</p>

                    <div class="flex justify-between items-center my-2">
                        <div>
                            <div class="text-gray-400  text-xl"><i class="far fa-images"></i></div>
                        </div>
                        <div class="text-center w-2/3 my-2">
                            <div class="flex justify-between">
                                <p class="text-gray-400 font-medium text-xs">Image 4</p>
                                <p class="text-gray-400 font-medium text-xs">87%</p>
                            </div>

                            <div class="border-1 overflow-hidden rounded-full  h-2 bg-cyan-100 mx-auto relative">
                                <div class="bg-cyan-500 h-2 absolute top-0 left-0" style="width: 50%;"></div>
                            </div>
                        </div>
                        <div>
                            <button class="rounded-full text-gray-400 hover:bg-gray-200 px-1 "><i
                                    class="fas fa-times"></i></button>
                        </div>
                    </div>

                    <div class="flex justify-between items-center my-2">
                        <div>
                            <div class="text-gray-400  text-xl"><i class="far fa-images"></i></div>
                        </div>
                        <div class="text-center w-2/3">
                            <div class="flex justify-between">
                                <p class="text-gray-400 font-medium text-xs">Image 4</p>
                                <p class="text-gray-400 font-medium text-xs">87%</p>
                            </div>

                            <div class="border-1 overflow-hidden rounded-full h-2 bg-cyan-100 mx-auto relative">
                                <div class="bg-cyan-500 h-2 absolute top-0 left-0" style="width: 50%;"></div>
                            </div>
                        </div>
                        <div>
                            <div class="rounded-full text-green-400 hover:bg-gray-200 px-1 "><i
                                    class="fas fa-check-circle"></i></i></div>
                        </div>
                    </div>
                </div>
            </div>
            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4"
                    role="alert">

                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif

        </div>

        @if ($errors->any())
            <div class="mb-4">
                <x-success-message-modal />
            </div>
        @endif

    </form>


</div>
