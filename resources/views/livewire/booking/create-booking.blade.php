<div>
    <form class="p-2" wire:submit.prevent="saveBooking">
        <div class="grid grid-cols-3 gap-5">

            <div class="col-span-2">
                <div class="w-full bg-white shadow rounded p-2">

                    <div class="m-4">
                        <div class="flex justify-between">
                            <h2 class="text-lg font-bold">Customer Details</h2>

                            <div>
                                <button type="button"
                                    x-on:click="$dispatch('open-modal', {name: 'select-customer-modal'})"
                                    class="bg-green-700 px-2 py-1 rounded shadow text-white">Search</button>
                            </div>
                        </div>

                        <div class="grid gap-4 mb-4 grid-cols-4">
                            <div class="col-span-2">
                                <x-text-field1 field1 name="firstname" placeholder="First Name" model="firstname"
                                    label="First Name" />
                            </div>

                            <div class="col-span-2">
                                <x-text-field1 field1 name="middlename" placeholder="Middle Name" model="middlename"
                                    label="Middle Name" />
                            </div>

                            <div class="col-span-2">
                                <x-text-field1 field1 name="lastname" placeholder="Last Name" model="lastname"
                                    label="Last Name" />
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <x-text-field1 field1 name="dob" placeholder="First Name" model="dob"
                                    type="date" label="Birthdate" />
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <x-combobox name="gender" model="gender" placeholder="Gender" :options="['Female', 'Male']" />
                            </div>

                            <div class="col-span-2">
                                <x-text-field1 field1 name="street" placeholder="Street" model="street"
                                    label="Street" />
                            </div>

                            <div class="col-span-2">
                                <x-text-field1 field1 name="brgy" placeholder="Brgy" model="brgy" label="Brgy" />
                            </div>

                            <div class="col-span-2">
                                <x-text-field1 field1 name="city" placeholder="City" model="city" label="City" />
                            </div>

                            <div class="col-span-2">
                                <x-text-field1 field1 name="province" placeholder="Povince" model="province"
                                    label="Province" />
                            </div>

                            <div class="col-span-2">
                                <x-text-field1 field1 name="email" placeholder="Email" model="email"
                                    label="Email" />
                            </div>

                            <div class="col-span-2">
                                <x-text-field1 field1 name="contactnumber" placeholder="Contact Number"
                                    model="contactnumber" label="Contact Number" />
                            </div>

                        </div>


                    </div>

                </div>
            </div>
            <div class="cols-span-1">
                <div class="w-full bg-slate-50 shadow rounded p-2">
                    <div class="flex justify-between px-2">
                        <h1 class="text-lg font-bold">Reservation Summary</h1>
                        <button x-on:click="$dispatch('open-modal', {name: 'select-room-modal'})" type="button">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </div>

                    <div class="border border-slate-200 rounded p-2 m-1">
                        <div class="grid grid-cols-2 gap-1">
                            <div>
                                <p class="text-xs text-slate-700">CHECK IN</p>
                                <input wire:model="checkIn"
                                    class="w-full bg-slate-100 p-2 rounded focus:outline-none border-none"
                                    type="text" value="" disabled>
                            </div>
                            <div>
                                <p class="text-xs text-slate-700">CHECK OUT</p>
                                <input wire:model="checkOut"
                                    class="w-full bg-slate-100 p-2 rounded focus:outline-none border-none"
                                    type="text" value="" disabled>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-1">
                            <div class="text-xs mt-5">
                                <h2>TOTAL LENGHT OF STAY:</h2>
                                <input wire:model="lengthOfStay"
                                    class="w-full bg-slate-100 p-2 rounded focus:outline-none border-none"
                                    type="text" value="" disabled>
                            </div>

                            <div class="text-xs mt-5">
                                <h2>TOTAL GUEST:</h2>
                                <input wire:model="totalGuests"
                                    class="w-full bg-slate-100 p-2 rounded focus:outline-none border-none"
                                    type="text" value="" disabled>
                            </div>

                        </div>



                        <div class="mt-5">
                            <h2 class="text-xs">YOU SELECTED</h2>

                            <p class="w-full bg-slate-100 p-2 rounded focus:outline-none border-none tex">
                                {{ $selectedRoom->RoomType ?? 'No Room Selected' }}
                            </p>
                        </div>
                    </div>

                    <div class="p-2">
                        <div class="flex justify-between pe-2 mb-2">
                            <h2 class="font-bold text-blue-950">Amenities</h2>
                            <button type="button" class=" " type="button"
                                x-on:click="$dispatch('open-modal', {name: 'select-amenities-modal'})">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </div>

                        <div class="border border-slate-200 rounded p-2">
                            @if (!$selectedAmenities)
                                <p class="text-xs text-slate-700">No Amenities Selected</p>
                            @endif

                            @foreach ($selectedAmenities as $amenity)
                                <div class="flex justify-between">
                                    <p>{{ $amenity['name'] }}</p>
                                    <p>{{ $amenity['price'] }}</p>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <div class="my-2">
                        <h2 class="font-bold">Payment Method</h2>
                        <div class="grid grid-rows-2 gap-2 mt-5">
                            <div class="text-xs flex items-center gap-2">
                                <input type="radio" value="Gcash" name="payment-type" wire:model="paymentType">
                                <label for="">Gcash</label>
                            </div>

                            <div class="text-xs flex items-center gap-2">
                                <input type="radio" value="Cash" name="payment-type" wire:model="paymentType">
                                <label for="">Cash</label>
                            </div>


                        </div>
                    </div>

                    <div class="my-2 grid grid-flow-row gap-2">
                        <div>
                            <h2 class="font-bold">Total Summary</h2>
                        </div>

                        <div class="flex justify-between text-xs">

                            @if (!$selectedRoom)
                                <p>No Room Selected</p>
                            @else
                                <p>{{ $selectedRoom->RoomType }}</p>
                                <p>{{ $selectedRoom->RoomPrice }}</p>
                            @endif

                        </div>

                        <div class="flex justify-between text-xs">

                            @if ($discount)
                                <p>Discount</p>
                                <p>{{ $total * ($discount->Discount / 100) }}</p>
                            @endif

                        </div>



                        <div class="grid grid-flow-row text-xs">
                            @foreach ($selectedAmenities as $amenity)
                                <div class="flex justify-between">
                                    <p>{{ $amenity['name'] . ' x ' . $amenity['quantity'] }}</p>
                                    <p>{{ $amenity['price'] }}</p>
                                </div>
                            @endforeach

                        </div>
                        <hr class="mt-1">

                        <div class="flex justify-between ">
                            <p class="font-bold text-blue-950">Total</p>
                            <p>{{ $discountedRoomRate }}</p>
                        </div>
                        <div>
                            <x-text-field1 -field1 name="paymentAmount" placeholder="Enter Amount"
                                model="paymentAmount" />

                        </div>
                    </div>
                    <div class="w-full mt-5">
                        <button type="submit" class="w-full bg-cyan-900 text-white py-2 rounded">Confirm
                            Booking</button>
                    </div>
                </div>
            </div>


        </div>
    </form>

    @if (session()->has('message'))
        <x-success-message-modal message="{{ session('message') }}" />
    @endif


    <x-modal title="Select Customer" name="select-customer-modal">

        @slot('body')

            <div class="my-2">
                <div class="grid grid-cols-1 gap-2">

                    <x-text-field1 field1 name="search" placeholder="Search Customer" model="search"
                        label="Search Customer" />


                </div>

            </div>
            <div class="max-h-96 overflow-auto bg-white rounded-md">
                @foreach ($guests as $guest)
                    <div class="p-2 shadow rounded-lg mx-1 my-4 flex justify-between items-center">
                        <div>
                            <p>{{ $guest->FirstName . ' ' . $guest->MiddleName . ' ' . $guest->LastName }}</p>
                        </div>

                        <div>
                            <button wire:click="selectGuest({{ $guest->GuestId }})" type="button"
                                class="bg-green-700 text-white px-2 py-1 rounded
                                hover:bg-white hover:border hover:border-green-900 duration-75 transition-all hover:text-slate-950">Select</button>
                        </div>

                    </div>
                @endforeach
            </div>
        @endslot
    </x-modal>

    <x-modal title="Select Amenities" name="select-amenities-modal">
        @slot('body')
            <div class="my-2">
                <div class="grid grid-cols-1 gap-2">

                    <x-text-field1 -field1 name="search" placeholder="Search Amenities" model="search"
                        label="Search Customer" />
                </div>

            </div>
            <div class="max-h-96 overflow-auto bg-white rounded-md">
                @foreach ($amenities as $amenity)
                    <div class="p-2 shadow rounded-lg mx-1 my-4 flex justify-between items-baseline">
                        <div>
                            <p class="text-slate-800">{{ $amenity->Name }}</p>
                        </div>
                        <div class="flex justify-evenly gap-2 w-1/3 items-center">
                            <div>
                                <button wire:click="updateAmenityQuantity({{ $amenity->AmenitiesId }}, -1)"
                                    type="button"
                                    class="bg-red-700 text-white px-2 py-1 rounded hover:bg-white hover:border hover:border-red-900 duration-75 transition-all hover:text-slate-950">
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div>
                                <input wire:model.defer="quantity.{{ $amenity->AmenitiesId }}" type="number"
                                    name="quantity[{{ $amenity->AmenitiesId }}]" min="0"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" />
                            </div>
                            <div>
                                <button wire:click="updateAmenityQuantity({{ $amenity->AmenitiesId }}, 1)" type="button"
                                    class="bg-green-700 text-white px-2 py-1 rounded hover:bg-white hover:border hover:border-green-900 duration-75 transition-all hover:text-slate-950">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        @endslot
    </x-modal>

    <x-select-room-modal name="select-room-modal" title="Select Room">
        @slot('body')

            <div class="flex justify-normal gap-5 rounded-lg shadow-lg p-2 mt-5">

                <div class="w-1/2">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white ">Check Out</label>
                    <input name="checkout" placeholder="Check Out" type="date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-50"
                        wire:model.live="checkOut" />
                </div>


                <div class="w-1/2">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total Adult
                    </label>
                    <select name="totalGuests" wire:model.live="totalGuests"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="">Total Adult</option>
                        @for ($i = 1; $i < 11; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor

                    </select>
                </div>

                <div class="w-1/2">

                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total Children
                    </label>
                    <select name="totalChildren" wire:model.live="totalChildren"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="">Total Adult</option>
                        @for ($i = 1; $i < 11; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor

                    </select>

                </div>

            </div>

            <div class="space-y-4 mt-5">
                <div class="space-y-4" wire:ignore>
                    @php
                        $groupedRooms = collect();

                        if ($rooms) {
                            $groupedRooms = $rooms->groupBy(function ($room) {
                                return floor($room->RoomNumber / 100) * 100;
                            });
                        }

                    @endphp


                    @if ($groupedRooms->isNotEmpty())
                        @foreach ($groupedRooms as $group => $room)
                            <div class="grid grid-cols-12 gap-2 m-2">
                                @foreach ($room as $room)
                                    <div class="relative group">
                                        <button wire:click="selectRoom({{ $room->RoomId }})"
                                            class="h-24 w-full
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
                                        </button>
                                        <div
                                            class="absolute top-1/2 left-full transform -translate-y-1/2 translate-x-2 w-96 mb-2 hidden group-hover:block z-50">
                                            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                                                <div class="h-52 bg-gray-200 flex items-center justify-center">
                                                    @if ($room->roomPictures->isNotEmpty())
                                                        <img src="data:image/png;base64,{{ base64_encode($room->roomPictures->first()->PictureFile) }}"
                                                            alt="{{ $room->RoomType }}"
                                                            class="object-cover h-full w-full">
                                                    @else
                                                        <div class="flex items-center justify-center h-full text-gray-500">
                                                            No
                                                            Image Available</div>
                                                    @endif
                                                </div>
                                                <div class="p-4">
                                                    <div class="flex justify-between">
                                                        <div class="font-bold text-lg">{{ $room->RoomType }}</div>
                                                        <div class="text-red-600">{{ $room->RoomStatus }}</div>
                                                    </div>
                                                    <div class="text-sm text-gray-700 mt-1">{{ $room->RoomDescription }}
                                                    </div>
                                                    <div class="mt-2">
                                                        <div class="flex justify-between">
                                                            <div class="font-bold">Price:</div>
                                                            <div class="text-red-600">{{ $room->RoomPrice }}</div>
                                                        </div>
                                                        <div class="text-sm text-gray-600">Room Capacity:
                                                            {{ $room->Capacity }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                </div>


            </div>
        @endslot
    </x-select-room-modal>


</div>
