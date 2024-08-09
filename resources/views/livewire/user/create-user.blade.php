<div>

    <form wire:submit.prevent="createRoom">



        @csrf

        <div class="flex justify-between ">

            <div class="p-2 bg-white rounded w-full shadow mx-2">
                <h1 class="mx-2 font-bold">Create User</h1>
                <div class="flex justify-between p-2 ">
                    <div class="border-b-4 border-cyan-600 w-auto px-10 flex justify-start p-1 align-middle">
                        <i class="far fa-check-circle text-cyan-500 mt-1 mx-2"></i>
                        <h4 class="text-cyan-500 font-bold">Profile Details</h4>
                    </div>

                </div>

                <div class="flex justify-normal p-2 w-full">

                    <div class="w-1/3 mx-2">

                        <x-text-field1 name="firstname" placeholder="Enter First Name" model="firstname" label="First Name" />
                        @error('middlename')
                            <p class="text-red-500 text-xs italic mt-1"><i
                                    class="fas fa-exclamation-circle"></i></i>{{ $message }}
                            </p>
                        @enderror

                    </div>

                    <div class="w-1/3 mx-2">

                        <x-text-field1 name="middlename" placeholder="Enter Middle Name" model="middlename" label="Middle Name" />
                        @error('middlename')
                            <p class="text-red-500 text-xs italic mt-1"><i
                                    class="fas fa-exclamation-circle"></i></i>{{ $message }}
                            </p>
                        @enderror

                    </div>

                    <div class="w-1/3 mx-2">

                        <x-text-field1 name="lastname" placeholder="Enter Last Name" model="lastname" label="Last Name" />
                        @error('rate')
                            <p class="text-red-500 text-xs italic mt-1"><i
                                    class="fas fa-exclamation-circle"></i></i>{{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>


                <div class="flex justify-normal p-2 w-full">

                    <div class="w-1/3 mx-2">

                        <x-text-field1 name="email" placeholder="Enter Email" model="email" label="Email" />
                        @error('rate')
                            <p class="text-red-500 text-xs italic mt-1"><i
                                    class="fas fa-exclamation-circle"></i></i>{{ $message }}
                            </p>
                        @enderror

                    </div>

                    <div class="w-1/3 mx-2">
                        <x-combobox name="gender" model="gender" placeholder="Select Gender" :options="['Male', 'Female']" />

                        @error('roomType')
                            <p class="text-red-500 text-xs italic mt-1"><i
                                    class="fas fa-exclamation-circle"></i></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="w-1/3 mx-2">
                        <x-combobox name="gender" model="gender" placeholder="Select Position" :options="['System Administrator', 'Manger', 'Receptionist']" />

                        @error('roomType')
                            <p class="text-red-500 text-xs italic mt-1"><i
                                    class="fas fa-exclamation-circle"></i></i>{{ $message }}
                            </p>
                        @enderror
                    </div>


                </div>

                <div class="justify-end flex p-1">

                    <div class="grid grid-row-2 grid-flow-col gap-2">
                        <button type="button" onclick="document.getElementById('roomModal').style.display = 'block';"
                            class="bg-red-400 font-medium text-white px-2 py-1 rounded ">
                            Cancel
                        </button>
                        <button type="submit" class="bg-cyan-400 font-medium text-white px-2 py-1 rounded ">
                            Create
                        </button>
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
