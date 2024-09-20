<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
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
    </style>
</head>

<body>

    <h1 style="text-align: center;">Daily Sales Report</h1>

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
            @foreach($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->room->RoomId }}</td>
                    <td>{{ $reservation->guest->FirstName . ' '. $reservation->guest->LastName }}</td>
                    <td>{{ number_format($reservation->TotalCost, 2) }}</td>
                    <td>{{ number_format($reservation->reservationAmenities->sum('cost'), 2) }}</td>
                    <td>{{ number_format($reservation->discount ?? 0, 2) }}</td>
                    <td>{{ number_format($reservation->TotalCost - ($reservation->discount ?? 0), 2) }}</td>
                    <td>{{ number_format($reservation->payments->sum('AmountPaid'), 2) }}</td>
                    <td>
                        @if($reservation->payments->sum('AmountPaid') == $reservation->TotalCost)
                            Paid
                        @else
                            Pending
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

</body>

</html>
