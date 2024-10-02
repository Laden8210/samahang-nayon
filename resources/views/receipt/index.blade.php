<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Official Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }

        .receipt-container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #000;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2, p {
            margin: 0;
            padding: 0;
        }

        .header, .subtitle, .customer-information, .service-list {
            margin-bottom: 20px;
        }

        .header h1 {
            text-align: center;
            font-size: 18px;
        }

        .header p {
            text-align: center;
        }

        .subtitle {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .underline {
            border-bottom: 1px solid #000;
            padding: 0 5px;
            display: inline-block;
            width: 70%;
        }

        .flex {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .service-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .service-list th, .service-list td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .service-list th {
            background-color: #f0f0f0;
        }

        .service-list td {
            text-align: right;
        }

        .service-list td:first-child {
            text-align: left;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="receipt-container">
        <div class="header">
            <h1>FEDERATION OF SOCSARGEN SAMAHANG NAYON COOPERATIVE</h1>
            <p>Samahang Nayon Bldg. Corner Osmena-Roxas Street, Zone II, Koronadal City</p>
            <p>NON VAT Reg TIN: 000-000-000-000</p>
        </div>

        <div class="subtitle">
            <div>
                <h2>Official Receipt</h2>
                <p>(Hotel)</p>
            </div>
            <div>
                <p>Reservation/Booking No: {{ $payment->ReferenceNumber }}</p>
                <h2>Date: {{ \Carbon\Carbon::parse($payment->DateCreated)->format('F d, Y') }}</h2>
            </div>
        </div>

        <div class="customer-information">
            <div class="flex">
                <p>Received from: </p>
                <div class="underline">
                    <span>{{ $payment->guest->FirstName }} {{ $payment->guest->LastName }}</span>
                </div>
            </div>

            <div class="flex">
                <p>With address at: </p>
                <div class="underline">
                    <span>{{ $payment->guest->Brgy . " " . $payment->guest->City . " " . $payment->guest->Province }}</span>
                </div>
            </div>

            <div class="flex">
                <p>Business Style: </p>
                <div class="underline">
                    <span>Hotel Reservation</span>
                </div>
            </div>

            <div class="flex">
                <p>TIN: </p>
                <div class="underline">
                    <span>{{ $payment->guest->TIN }}</span>
                </div>
            </div>

            <div class="flex">
                <p>Amount: </p>
                <div class="underline">
                    <span>PHP {{ number_format($payment->AmountPaid, 2) }} ({{ $amountInWords }})</span>
                </div>
            </div>

            <div class="flex">
                <p>By: </p>
                <div class="underline">
                    <span>{{ $payment->Cashier }}</span>
                </div>
            </div>
        </div>



        <div class="footer">
            <p>Thank you for your business!</p>
        </div>

    </div>

</body>

</html>
