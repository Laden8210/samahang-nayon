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

                <button x-data x-on:click="$dispatch('open-modal', {name: 'add-modal-payment'})"
                    class="bg-green-800 text-white px-2 py-3 rounded-lg border hover:border-green-800 hover:text-slate-950 hover:bg-white">Check
                    Balance</button>

                <button x-data x-on:click="$dispatch('open-modal', {name: 'add-modal-amenities'})"
                    class="bg-green-800 text-white px-2 py-3 rounded-lg border hover:border-green-800 hover:text-slate-950 hover:bg-white">Add
                    Amenities</button>


                <button x-data x-on:click="$dispatch('open-modal', {name: 'add-guest'})"
                    class="bg-green-800 text-white px-2 py-3 rounded-lg border hover:border-green-800 hover:text-slate-950 hover:bg-white">Add
                    Additional guest</button>


                <a href="{{ route('printReceipt', $reservation->ReservationId) }}" target="_blank"
                    class="bg-green-800 text-white px-2 py-3 rounded-lg border hover:border-green-800 hover:text-slate-950 hover:bg-white">Print
                    Receipt</a>

                {{-- <a //href="{{ route('receipt', ['view' => Crypt::encrypt($payment->ReferenceNumber)]) }}" target="_blank"
                        class="bg-green-800 text-white px-2 py-3 rounded-lg border hover:border-green-800 hover:text-slate-950 hover:bg-white">Generate Receipt</a>
 --}}

            </div>
        </div>


        <x-modal title="Add Payment" name="add-modal-payment">
            @slot('body')
                <form wire:submit.prevent="addPayment">
                    <div class="grid gap-4 mb-4 grid-cols-2">

                        <div class="col-span-2">


                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white ">Remaining
                                Balance</label>
                            <input type="number" wire:model="payment" name="payment"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-50"
                                placeholder="Enter the amount to paid" readonly>
                            @error('payment')
                                <p class="text-red-500 text-xs italic mt-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Confirm Payment
                    </button>
                </form>
            @endslot
        </x-modal>

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

        <div class="grid grid-cols-3 mt-2 shadow-lg rounded-lg mb-5 p-5 text-xs ">
            <div class="grid grid-cols-2 gap-2 items-start">
                <div class="font-bold text-xs">Reservation Number:</div>
                <div>{{ $reservation->ReservationId }}</div>
                <div class="font-bold  text-xs">Date</div>
                <div>{{ $reservation->DateCreated }}</div>
                <div class="font-bold text-xs">Guest</div>
                <div>
                    {{ $reservation->guest->FirstName ?? ('' . ' ' . $reservation->guest->LastName ?? '') }}
                </div>
                <div class="font-bold  text-xs">Contact Number</div>
                <div>
                    {{ $reservation->guest->ContactNumber }}
                </div>

                <div class="font-bold  text-xs">Email</div>
                <div>
                    {{ $reservation->guest->EmailAddress }}
                </div>
            </div>

            <div class="grid grid-cols-2 mt-2">
                <div class="font-bold text-xs">Total guest</div>
                <div>
                    {{ 'Adults ' . $reservation->TotalAdult . ' Children ' . $reservation->TotalChildren }}
                </div>
                <div class="font-bold  text-xs">Status:</div>
                <div>{{ $reservation->Status }}</div>
                <div class="font-bold text-xs">Check In Date:</div>
                <div>{{ $reservation->DateCheckIn }}</div>
                <div class="font-bold  text-xs">Check Out Date:</div>
                <div>{{ $reservation->DateCheckOut }}</div>
            </div>



            <div class="grid grid-cols-2 mt-2 text-xs">

                <div class="font-bold  text-xs">Discount Type</div>
                <div>
                    {{ $reservation->DiscountType ?? 'No Discount' }}
                </div>

                <div class="font-bold text-xs">ID Number</div>
                <div>
                    {{ $reservation->IdNumber }}
                </div>
                <div class="font-bold  text-xs">Total Room Cost</div>
                <div> ₱
                    {{ $reservation->TotalCost }}
                </div>

                <div class="font-bold text-xs">Total Amenities Cost</div>
                <div>₱
                    @php
                        $totalAmenities = 0;
                        foreach ($reservation->reservationAmenities as $amenity) {
                            $totalAmenities += $amenity->TotalCost;
                        }
                        echo $totalAmenities;
                    @endphp
                </div>

                <div class="font-bold  text-xs">Penalty</div>
                <div>
                    ₱ 0</div>


                <div class="font-bold  text-xs">Total Payment</div>
                <div>
                    ₱
                    @php
                        $totalPayment = 0;
                        foreach ($reservation->payments as $payment) {
                            if ($payment->Status === 'Pending') {
                                continue;
                            }

                            $totalPayment += $payment->AmountPaid;
                        }
                        echo $totalPayment;
                    @endphp</div>

                <div class="font-bold  text-xs">Balance</div>
                <div>
                    ₱{{ $reservation->TotalCost + $totalAmenities - $totalPayment }}
                </div>

            </div>
        </div>

        <div class="grid grid-cols-2 gap-2">
            <div class=" p-2 min-h-40 max-h-96">
                <h1 class="text-xl font-bold">Room Details</h1>
                <table class="w-full overflow-auto mt-2">
                    <thead class="text-xs uppercase bg-gray-50">
                        <tr class="text-center">
                            <th class="px-2 py-3">Room Type</th>
                            <th class="px-2 py-3">Room Number</th>
                            <th class="px-2 py-3">Room Rate</th>

                            <th class="px-2 py-3">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-slate-100 text-center">
                            <td class="py-3">{{ $reservation->roomNumber->room->RoomType }}</td>
                            <td>{{ $reservation->roomNumber->room_number }}</td>
                            <td> ₱{{ $reservation->roomNumber->room->RoomPrice }}</td>

                            <td> ₱{{ $reservation->TotalCost }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class=" p-2 min-h-40">
                <div class="flex justify-between">
                    <h1 class="text-xl font-bold">Amenties Details</h1>

                </div>

                <table class="w-full overflow-auto mt-2">
                    <thead class="text-xs uppercase bg-gray-50">
                        <tr class="text-center">
                            <th class="px-2 py-3">Amenities</th>
                            <th class="px-2 py-3">Price</th>
                            <th class="px-2 py-3">Total</th>
                            <th class="px-2 py-3">Total Amount</th>
                            <th class="px-2 py-3">Action</th>

                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($reservation->reservationAmenities as $amenity)
                            <tr class="border-b border-slate-100 text-center">
                                <td class="px-2 py-3">
                                    {{ $amenity->amenity->Name ?? '' }}
                                </td>
                                <td class="px-2 py-3">
                                    ₱ {{ $amenity->amenity->Price ?? '' }}
                                </td>
                                <td class="px-2 py-3">
                                    {{ $amenity->Quantity ?? '' }}
                                </td class="px-2 py-3">
                                <td>
                                    ₱{{ $amenity->TotalCost ?? '' }}
                                </td>

                                <td>
                                    <button class="bg-red-600 px-2 py-1 rounded text-white hover:bg-red-900"
                                        type="button"
                                        wire:click="removeAmenity({{ $amenity->ReservationAmenitiesId }})"><i class="fa fa-trash" aria-hidden="true"></i></button>

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
                    <thead class="text-xs uppercase bg-gray-50">
                        <tr class="text-center">
                            <th class="px-2 py-3">Reference Number</th>
                            <th class="px-2 py-3">Payment Status</th>
                            <th class="px-2 py-3">Time</th>
                            <th class="px-2 py-3">Date</th>
                            <th class="px-2 py-3">Payment Method</th>
                            <th class="px-2 py-3">Amount</th>
                            <th class="px-2 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservation->payments as $payment)
                            <tr class="border-b border-slate-100 text-center">
                                <td class="px-2 py-3">{{ $payment->ReferenceNumber }}</td>
                                <td class="px-2 py-3">{{ $payment->Status }}</td>
                                @php
                                    // Format the date and time using Carbon
                                    $formattedDate = \Carbon\Carbon::parse($payment->DateCreated)
                                        ->setTimezone('Asia/Manila')
                                        ->format('F j, Y');
                                    $formattedTime = \Carbon\Carbon::parse($payment->TimeCreated)
                                        ->setTimezone('Asia/Manila')
                                        ->format('g:i A');
                                @endphp

                                <td class="px-2 py-3">{{ $formattedTime }}</td>
                                <td class="px-2 py-3">{{ $formattedDate }}</td>


                                <td class="px-2 py-3">{{ $payment->PaymentType }}</td>
                                <td class="px-2 py-3"> ₱{{ $payment->AmountPaid }}</td>
                                <td>
                                    @if ($payment->PaymentType === 'Gcash' && $payment->Status === 'Pending')
                                        <button class="bg-cyan-600 px-2 py-2 rounded text-white hover:bg-cyan-900"
                                            type="button"
                                            wire:click="confirmPayment({{ $payment->PaymentId }})">Confirm
                                            Payment</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>

        <div class="p-2 min-h-40 col-span-2">
            <div class="flex justify-between">
                <h1 class="text-xl font-bold">Additional Guest</h1>

            </div>
            <table class="w-full">
                <thead class="text-xs uppercase bg-gray-50">
                    <tr class="text-center">
                        <th class="px-2 py-3">Full Name</th>
                        <th class="px-2 py-3">Birthdate</th>
                        <th class="px-2 py-3">Gender</th>
                        <th class="px-2 py-3">Contact Number</th>

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

                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>

    @if (session()->has('message'))
        <x-success-message-modal message="{{ session('message') }}" />
    @endif



    <x-modal title="Add Guest" name="add-guest">

        @slot('body')
            <form wire:submit.prevent="addSubGuest">


                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <x-text-field1 field1 name="firstname" placeholder="First Name" model="subguestsFirstname"
                            label="First Name" />
                        @error('subguestsFirstname')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <x-text-field1 field1 name="middlename" placeholder="Middle Name" model="subguestsMiddlename"
                            label="Middle Name" />
                    </div>

                    <div>
                        <x-text-field1 field1 name="lastname" placeholder="Last Name" model="subguestsLastname"
                            label="Last Name" />
                        @error('subguestsLastname')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <x-combobox name="gender" model="subguestsGender" placeholder="Gender" :options="['Female', 'Male']" />
                        @error('subguestsGender')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <x-text-field1 field1 name="dob" placeholder="Birthdate" model="subguestsDob" type="date"
                            label="Birthdate" />
                        @error('subguestsDob')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <x-text-field1 field1 name="contactnumber" placeholder="Contact Number"
                            model="subguestsContactnumber" type="number" label="Contact Number" />
                        @error('subguestsContactnumber')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>



                    <div class="flex justify-end col-span-2 gap-2">
                        <button class="px-2 py-2 bg-red-600 rounded shadow text-white" type="button"
                            x-on:click="$dispatch('close-modal')">Cancel</button>
                        <button class="px-2 py-2 bg-green-600 rounded shadow text-white" type="submit">Add Guest</button>
                    </div>
                </div>
            </form>
        @endslot

    </x-modal>

    @if (session()->has('subguest-message'))
        <x-success-message-modal message="{{ session('subguest-message') }}" />
    @endif


    <div wire:loading>
        <x-loader />
    </div>

</div>
