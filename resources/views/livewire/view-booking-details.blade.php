<div class="block p-5" wire:ignore.self>
    <div class="flex justify-between">
        <div>
            <h1 class="text-2xl font-bold">Booking Details</h1>
        </div>
        <div class="flex justify-end">



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

            {{--
            <button wire:click="checkIn"
                class="bg-green-800 text-white px-2 py-3 border hover:border-green-800 hover:text-slate-950 hover:bg-white">Add
                Payment</button>

            <button wire:click="checkIn"
                class="bg-green-800 text-white px-2 py-3 border hover:border-green-800 hover:text-slate-950 hover:bg-white">Add
                Amenities</button> --}}

        </div>
    </div>


    <div class="grid grid-cols-2 mt-2 shadow-lg rounded-lg mb-5 p-5">
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
                        <th class="px-2 py-3">Price</th>
                        <th class="px-2 py-3">Room Number</th>
                        <th class="px-2 py-3">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-slate-100 text-center">
                        <td class="py-3">{{ $reservation->room->RoomType }}</td>
                        <td>{{ $reservation->room->RoomPrice }}</td>
                        <td>{{ $reservation->room->RoomNumber }}</td>
                        <td>{{ $reservation->Disburse }}</td>
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

    @if (session()->has('message'))
        <x-success-message-modal message="{{ session('message') }}" />
    @endif


</div>
