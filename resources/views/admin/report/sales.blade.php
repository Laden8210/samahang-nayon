<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        td {
            text-align: right;
        }

        td:first-child {
            text-align: left;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .logo img {
            width: 100px;
        }
    </style>
</head>

<body>

    <div class="logo">
        <img src="{{ public_path('img/logo.jpg') }}" alt="Logo">
    </div>

    <p style="text-align: center;">FEDERATION OF SOCSARGEN SAMAHANG NAYON</p>
    <p style="text-align: center;">COOPERATIVES (FSSNC)</p>
    <p style="text-align: center;">SAMAHANG NAYON HOTEL</p>


    <h3 style="text-align: center;">{{ $report->type ?? 'N/A' }}</h3>
    <p style="text-align: center;">Period: From {{ $report->Date }} {{ 'to ' . $report->EndDate ?? '' }} </p>

    @if ($report->type === 'Reservation Report')
        <table>
            <thead>
                <tr>

                    <th>Guest Name</th>
                    <th>Room No</th>
                    <th>Room Type</th>
                    <th>Check in Date</th>
                    <th>Check out date</th>
                    <th>No. of Nights</th>
                    <th>Booking Source</th>
                </tr>
            </thead>
            <tbody>


                @foreach ($reservations as $reservation)
                    <tr>

                        <td>{{ $reservation->guest->FirstName . ' ' . $reservation->guest->LastName }}</td>
                        <td>{{ $reservation->room->RoomType }}</td>
                        <td>{{ $reservation->room->RoomNumber }}</td>
                        <td>{{ $reservation->DateCheckIn }}</td>
                        <td>{{ $reservation->DateCheckOut }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->DateCheckIn)->diffInDays(\Carbon\Carbon::parse($reservation->DateCheckOut)) }}
                        </td>

                        <td>{{ $reservation->Source }}</td>

                    </tr>
                @endforeach
            </tbody>

        </table>
    @elseif ($report->type === 'Arrival and Departure Report')
        <table>
            <h5>Scheduled Arrivals</h5>
            <thead>
                <tr>

                    <th>Guest Name</th>
                    <th>Room No</th>
                    <th>Room Type</th>
                    <th>Check in Date</th>
                    <th>Check in time</th>
                    <th>No. of Nights</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>


                @foreach ($reservations as $reservation)
                    @foreach ($reservation->checkInOuts as $checkInOut)
                        @if ($checkInOut->Type === 'Checked In')
                            <tr>
                                <td>{{ $reservation->guest->FirstName . ' ' . $reservation->guest->LastName }}</td>
                                <td>{{ $reservation->room->RoomType }}</td>
                                <td>{{ $reservation->room->RoomNumber }}</td>
                                <td>{{ $reservation->DateCheckIn }}</td>
                                <td>{{ $checkInOut->TimeCreated }}</td>
                                <td>{{ \Carbon\Carbon::parse($reservation->DateCheckIn)->diffInDays(\Carbon\Carbon::parse($reservation->DateCheckOut)) }}
                                </td>
                                <td>{{ $checkInOut->Type }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach

            </tbody>
        </table>


        <table>
            <h5>Scheduled Departures</h5>
            <thead>
                <tr>

                    <th>Guest Name</th>
                    <th>Room No</th>
                    <th>Room Type</th>
                    <th>Check out Date</th>
                    <th>Check out time</th>
                    <th>No. of Nights</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>


                @foreach ($reservations as $reservation)
                    @foreach ($reservation->checkInOuts as $checkInOut)
                        @if ($checkInOut->Type === 'Checked Out')
                            <tr>
                                <td>{{ $reservation->guest->FirstName . ' ' . $reservation->guest->LastName }}</td>
                                <td>{{ $reservation->room->RoomType }}</td>
                                <td>{{ $reservation->room->RoomNumber }}</td>
                                <td>{{ $reservation->DateCheckIn }}</td>
                                <td>{{ $checkInOut->TimeCreated }}</td>
                                <td>{{ \Carbon\Carbon::parse($reservation->DateCheckIn)->diffInDays(\Carbon\Carbon::parse($reservation->DateCheckOut)) }}
                                </td>
                                <td>{{ $checkInOut->Type }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @elseif ($report->type === 'Cancellation Report')
        <table>
            <h5>Scheduled Arrivals</h5>
            <thead>
                <tr>

                    <th>Guest Name</th>
                    <th>Room No</th>
                    <th>Room Type</th>
                    <th>Reservation Date</th>
                    <th>Check In Date</th>
                    <th>Date of Cancellation</th>

                </tr>
            </thead>
            <tbody>


                @foreach ($reservations as $reservation)
                    @if ($reservation->Status === 'Cancelled')
                        <tr>
                            <td>{{ $reservation->guest->FirstName . ' ' . $reservation->guest->LastName }}</td>
                            <td>{{ $reservation->room->RoomType }}</td>
                            <td>{{ $reservation->room->RoomNumber }}</td>
                            <td>{{ $reservation->DateCreated }}</td>
                            <td>{{ $reservation->DateCheckIn }}</td>
                            <td>{{ $reservation->DateCancelled }}</td>
                        </tr>
                    @endif
                @endforeach

            </tbody>
        </table>
    @else
        <table>
            <thead>
                <tr>
                    <th>Room No</th>
                    <th>Guest Name</th>
                    <th>Room Charge</th>
                    <th>Amenities Cost</th>
                    <th>Discount</th>
                    <th>Total Cost</th>
                    <th>Amount Paid</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->room->RoomNumber }}</td>
                    <td>{{ $reservation->guest->FirstName . ' ' . $reservation->guest->LastName }}</td>
                    <td>{{ number_format($reservation->TotalCost, 2) }}</td>
                    <td>{{ number_format($reservation->reservationAmenities->sum('TotalCost'), 2) }}</td>
                    <td>{{ number_format($reservation->discount ?? 0, 2) }}</td>
                    <td>{{ number_format($reservation->TotalCost - ($reservation->discount ?? 0) + (+ $reservation->reservationAmenities->sum('TotalCost')), 2) }}</td>
                    <td>{{ number_format($reservation->payments->sum('AmountPaid') , 2) }}</td>
                    <td>
                        @if ($reservation->payments->sum('AmountPaid') >= $reservation->TotalCost)
                            Paid
                        @else
                            Pending
                        @endif
                    </td>
                </tr>
            @endforeach

            </tbody>

        </table>

        <h3>Summary</h3>

        <h5><strong>Total Room Charge: </strong> <span
                style="font-weight: normal;">{{ number_format($reservations->sum('TotalCost'), 2) }}</span>
        </h5>
        <h5><strong>Total Amenities Cost: </strong> <span style="font-weight: normal;">
                {{ number_format(
                    $reservations->sum(function ($reservation) {
                        return $reservation->reservationAmenities->sum('cost');
                    }),
                    2,
                ) }}</span>
        </h5>

        <h5><strong>Total Sales: </strong> <span style="font-weight: normal;">
                {{ number_format(
                    $reservations->sum(function ($reservation) {
                        return $reservation->TotalCost - ($reservation->discount ?? 0);
                    }),
                    2,
                ) }}</span>
        </h5>

    @endif



    <div>
        <h3>
            Prepared by:
        </h3>
        <h2>
            {{ $report->employee->FirstName . ' ' . $report->employee->LastName }}
        </h2>
        <h5>{{ $report->employee->Position }}</h5>

        <h5>Generated on: {{ date('F j, Y') }}</h5>

    </div>


</body>

</html>
