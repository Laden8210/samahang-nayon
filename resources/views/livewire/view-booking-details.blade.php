<div class="block p-5">
    <div class="flex justify-between">
        <div>
            <h1 class="text-2xl font-bold">Booking Details</h1>
        </div>
        <div>
            <button class="bg-green-600 rounded px-2 py-1 text-white hover:bg-white border-2 hover:border-green-950 hover:text-slate-950">Check In</button>
        </div>
    </div>

    <div class="w-2/3 h-40 my-2">
        <div class="grid grid-cols-2 mt-2">
            <div class="grid grid-cols-2 gap-2 items-start">
                <div>Date</div>
                <div>{{$reservation->DateCreated}}</div>
                <div>Guest</div>
                <div>{{$reservation->guest->FirstName .' '. $reservation->guest->MiddleName[0] . '. '. $reservation->guest->LastName}}</div>
            </div>

            <div class="grid grid-cols-2 mt-2">
                <div>Reservation Number:</div>
                <div>{{$reservation->ReservationId}}</div>
                <div>Check In Date:</div>
                <div>{{$reservation->DateCheckIn}}</div>
                <div>Check Out Date:</div>
                <div>{{$reservation->DateCheckOut}}</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-2">
        <div class="rounded shadow p-2 min-h-40 max-h-96">
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
                        <td class="py-3">Room Type here</td>
                        <td>Price here</td>
                        <td>Room Number here</td>
                        <td>Total here</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="rounded shadow p-2 min-h-40">
            <div class="flex justify-between">
                <h1 class="text-xl font-bold">Amenties Details</h1>
                <button class="bg-green-600 rounded px-2 py-1 text-white hover:bg-white border-2 hover:border-green-950 hover:text-slate-950">Add Amenities</button>
            </div>

            <table class="w-full">
                <thead>
                    <tr>
                        <th>Amenities</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>

            </table>
        </div>

        <div class="rounded shadow p-2 min-h-40">
            <h1 class="text-xl font-bold">Payment Details</h1>
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Payment Method</th>
                        <th>Amount</th>
                        <th>Payment Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Payment Method here</td>
                        <td>Amount here</td>
                        <td>Payment Date here</td>
                    </tr>
            </table>
        </div>

        <div class="rounded shadow p-2 min-h-40">
            <div class="flex justify-between">
                <h1 class="text-xl font-bold">Transaction Details</h1>
                <button class="bg-green-600 rounded px-2 py-1 text-white hover:bg-white border-2 hover:border-green-950 hover:text-slate-950">Add Payment</button>
            </div>
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Reference Number</th>
                        <th>Payment Status</th>
                        <th>Time</th>
                        <th>Date</th>
                        <th>Payment Method</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Reference Number here</td>
                        <td>Payment Status here</td>
                        <td>Time here</td>
                        <td>Date here</td>
                        <td>Payment Method here</td>
                        <td>Amount here</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>

</div>
