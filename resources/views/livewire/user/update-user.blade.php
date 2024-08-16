<div>
    <form wire:submit.prevent="updateUser">
        @csrf

        <div class="flex justify-between">
            <div class="p-2 bg-white rounded w-full shadow mx-2">
                <h1 class="mx-2 font-bold">Update User</h1>
                <div class="flex justify-between p-2">
                    <div class="border-b-4 border-cyan-600 w-auto px-10 flex justify-start p-1 align-middle">
                        <i class="far fa-check-circle text-cyan-500 mt-1 mx-2"></i>
                        <h4 class="text-cyan-500 font-bold">Profile Details</h4>
                    </div>
                </div>

                <div class="grid grid-cols-3 p-2 w-full">
                    <div class="mx-2">
                        <x-text-field1 name="firstname" placeholder="Enter First Name" model="firstname" label="First Name" />
                        @error('firstname')
                            <p class="text-red-500 text-xs italic mt-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mx-2">
                        <x-text-field1 name="middlename" placeholder="Enter Middle Name" model="middlename" label="Middle Name" />
                        @error('middlename')
                            <p class="text-red-500 text-xs italic mt-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mx-2">
                        <x-text-field1 name="lastname" placeholder="Enter Last Name" model="lastname" label="Last Name" />
                        @error('lastname')
                            <p class="text-red-500 text-xs italic mt-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-3 p-2 w-full">
                    <div class="mx-2">
                        <x-text-field1 name="contactNumber" placeholder="Enter Contact Number" model="contactNumber" label="Contact Number" />
                        @error('contactNumber')
                            <p class="text-red-500 text-xs italic mt-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mx-2">
                        <x-text-field1 name="email" placeholder="Enter Email Address" model="email" label="Email Address" />
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mx-2">
                        <x-text-field1 name="street" placeholder="Enter Street" model="street" label="Street" />
                        @error('street')
                            <p class="text-red-500 text-xs italic mt-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-3 p-2 w-full">
                    <div class="mx-2">
                        <x-text-field1 name="city" placeholder="Enter City" model="city" label="City" />
                        @error('city')
                            <p class="text-red-500 text-xs italic mt-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mx-2">
                        <x-text-field1 name="province" placeholder="Enter Province" model="province" label="Province" />
                        @error('province')
                            <p class="text-red-500 text-xs italic mt-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mx-2">
                        <x-text-field1 name="dob" type="date" placeholder="Enter Birthdate" model="dob" label="Birthdate" />
                        @error('dob')
                            <p class="text-red-500 text-xs italic mt-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-3 p-2 w-full">
                    <div class="mx-2">
                        <x-combobox name="gender" model="gender" placeholder="Select Gender" :options="['Male', 'Female']" />
                        @error('gender')
                            <p class="text-red-500 text-xs italic mt-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mx-2">
                        <x-combobox name="position" model="position" placeholder="Select Position" :options="['System Administrator', 'Manager', 'Receptionist']" />
                        @error('position')
                            <p class="text-red-500 text-xs italic mt-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-end justify-end mx-2">
                        <div class="flex gap-2">
                            <a href="{{ route('user') }}" class="bg-red-400 font-medium text-white px-2 py-1 rounded">Cancel</a>
                            <button type="submit" class="bg-cyan-400 font-medium text-white px-2 py-1 rounded">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            @if (session()->has('message'))
                <x-success-message-modal message="{{ session('message') }}" />
            @endif
        </div>
    </form>
</div>
