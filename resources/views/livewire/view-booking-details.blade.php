<div class="block p-5" wire:ignore.self>
    <div>
        <div class="flex justify-between">
            <div>
                <h1 class="text-2xl font-bold">Booking Details</h1>
            </div>
            <div class="flex justify-end gap-2">



                @if ($reservation->Status == 'Checked In')
                    <button wire:click="checkOut"
                        class="bg-green-800 text-white px-2 py-3 rounded-lg border hover:border-green-800 hover:text-slate-950 hover:bg-white">
                        Check Out
                    </button>
                @elseif ($reservation->Status != 'Checked Out')
                    <button wire:click="checkIn"
                        class="bg-green-800 text-white px-2 py-3 rounded-lg border hover:border-green-800 hover:text-slate-950 hover:bg-white">
                        Check In
                    </button>
                @endif

                <button wire:click="checkIn"
                    class="bg-green-800 text-white px-2 py-3 rounded-lg border hover:border-green-800 hover:text-slate-950 hover:bg-white">Add
                    Payment</button>

                <button x-data x-on:click="$dispatch('open-modal', {name: 'add-modal-amenities'})"
                    class="bg-green-800 text-white px-2 py-3 rounded-lg border hover:border-green-800 hover:text-slate-950 hover:bg-white">Add
                    Amenities</button>

            </div>
        </div>


        <x-modal title="Add New Amenities" name="add-modal-amenities">
            @slot('body')
                <form wire:submit.prevent="addAmenities">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="amenitySelect" class="block text-sm font-medium text-gray-700">Select
                                Amenity</label>
                            <select wire:model="amenity_id" id="amenitySelect"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-50">
                                <option value="">Select an Amenity</option> <!-- Default option -->
                                @foreach ($Amenities as $amenity)
                                    <option value="{{ $amenity->AmenitiesId }}">{{ $amenity->Name }}</option>
                                @endforeach
                            </select>
                            @error('amenity_id')
                                <p class="text-red-500 text-xs italic mt-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="col-span-2">
                            <x-text-field1 name="quantity" placeholder="Enter the quantity" model="quantity"
                                label="Quantity" type="number" />
                            @error('quantity')
                                <p class="text-red-500 text-xs italic mt-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Add New Amenities
                    </button>
                </form>
            @endslot
        </x-modal>

        <div class="grid grid-cols-3 mt-2 shadow-lg rounded-lg mb-5 p-5">
            <div class="grid grid-cols-2 gap-2 items-start">
                <div class="font-bold text-base">Reservation Number:</div>
                <div>{{ $reservation->ReservationId }}</div>
                <div class="font-bold  text-base">Date</div>
                <div>{{ $reservation->DateCreated }}</div>
                <div class="font-bold  text-base">Guest</div>
                <div>
                    {{ $reservation->guest->FirstName . ' ' . $reservation->guest->MiddleName[0] . '. ' . $reservation->guest->LastName }}
                </div>
            </div>

            <div class="grid grid-cols-2 mt-2">
                <div class="font-bold  text-base">Status:</div>
                <div>{{ $reservation->Status }}</div>
                <div class="font-bold  text-base">Check In Date:</div>
                <div>{{ $reservation->DateCheckIn }}</div>
                <div class="font-bold  text-base">Check Out Date:</div>
                <div>{{ $reservation->DateCheckOut }}</div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2">
            <div class=" p-2 min-h-40 max-h-96">
                <h1 class="text-xl font-bold">Room Details</h1>
                <table class="w-full overflow-auto mt-2">
                    <thead class="">
                        <tr class="bg-slate-100">
                            <th class="px-2 py-3">Room Type</th>
                            <th class="px-2 py-3">Room Number</th>
                            <th class="px-2 py-3">Price</th>

                            <th class="px-2 py-3">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-slate-100 text-center">
                            <td class="py-3">{{ $reservation->room->RoomType }}</td>
                            <td>{{ $reservation->room->RoomNumber }}</td>
                            <td>{{ $reservation->room->RoomPrice }}</td>

                            <td>{{ $reservation->TotalCost }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class=" p-2 min-h-40">
                <div class="flex justify-between">
                    <h1 class="text-xl font-bold">Amenties Details</h1>

                </div>

                <table class="w-full overflow-auto mt-2">
                    <thead class="bg-slate-100">

                        <tr>
                            <th class="px-2 py-3">Amenities</th>
                            <th class="px-2 py-3">Price</th>
                            <th class="px-2 py-3">Total</th>
                            <th class="px-2 py-3">Total Amount</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($reservation->reservationAmenities as $amenity)
                            <tr class="border-b border-slate-100 text-center">
                                <td class="px-2 py-3">
                                    {{ $amenity->amenity->Name }}
                                </td>
                                <td class="px-2 py-3">
                                    {{ $amenity->amenity->Price }}
                                </td>
                                <td class="px-2 py-3">
                                    {{ $amenity->Quantity }}
                                </td class="px-2 py-3">
                                <td>
                                    {{ $amenity->TotalCost }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <div class="p-2 min-h-40 col-span-2">
                <div class="flex justify-between">
                    <h1 class="text-xl font-bold">Transaction Details</h1>

                </div>
                <table class="w-full">
                    <thead class="bg-slate-100">
                        <tr>
                            <th class="px-2 py-3">Reference Number</th>
                            <th class="px-2 py-3">Payment Status</th>
                            <th class="px-2 py-3">Time</th>
                            <th class="px-2 py-3">Date</th>
                            <th class="px-2 py-3">Payment Method</th>
                            <th class="px-2 py-3">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservation->payments as $payment)
                            <tr class="border-b border-slate-100 text-center">
                                <td class="px-2 py-3">{{ $payment->ReferenceNumber }}</td>
                                <td class="px-2 py-3">{{ $payment->Status }}</td>
                                <td class="px-2 py-3">{{ $payment->TimeCreated }}</td>
                                <td class="px-2 py-3">{{ $payment->DateCreated }}</td>
                                <td class="px-2 py-3">{{ $payment->PaymentType }}</td>
                                <td class="px-2 py-3">{{ $payment->AmountPaid }}</td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>

        <div class="p-2 min-h-40 col-span-2">
            <div class="flex justify-between">
                <h1 class="text-xl font-bold">Sub Guest</h1>

            </div>
            <table class="w-full">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-2 py-3">Full Name</th>
                        <th class="px-2 py-3">Birthdate</th>
                        <th class="px-2 py-3">Gender</th>
                        <th class="px-2 py-3">Contact Number</th>
                        <th class="px-2 py-3">Email</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservation->subGuests as $guest)
                        <tr class="border-b border-slate-100 text-center">
                            <td class="px-2 py-3">
                                {{ $guest->FirstName . ' ' . ($guest->MiddleName ? $guest->MiddleName . ' ' : '') . $guest->LastName }}
                            </td>
                            <td class="px-2 py-3">{{ $guest->Birthdate }}</td>
                            <td class="px-2 py-3">{{ $guest->Gender }}</td>
                            <td class="px-2 py-3">{{ $guest->ContactNumber }}</td>
                            <td class="px-2 py-3">{{ $guest->EmailAddress }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>

    @if (session()->has('message'))
        <x-success-message-modal message="{{ session('message') }}" />
    @endif


</div>
