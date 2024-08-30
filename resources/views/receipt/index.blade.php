<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Official Receipt</title>
    <style>
        /* * {
            margin: 0;
            padding: 0;

        }
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .receipt-container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #000;
            display: grid;
            grid-template-columns: 200px auto;
        }
        .left {
            border-right: 1px solid #000;
        }
        .right {
            padding-left: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        h1 {
            margin-bottom: 10px;
        } */

        .flex {
            display: flex;
        }
        .justify-normal {
            justify-content: normal;
        }
        .underline {
            border-bottom: 1px solid #000;
            padding: 0 10px;
        }
    </style>
</head>

<body>

    <div class="receipt-container">
        <div class="left">
            <table>
                <tbody>
                    <tr>
                        <td>In the Settlement of the following</td>
                    </tr>
                    <tr>
                        <td>Invoice No.</td>
                        <td>Invoice No.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="right">
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
                    <p>Reservation/Booking No. </p>
                    <h2>Date July 17, 2024</h2>
                </div>

            </div>

            <div class="customer-information">
                <div class="flex justify-normal">
                    <p>Received By</p>
                    <div class="underline" style="width:80%">
                        <span>Name Here</span>
                    </div>
                </div>
                <div class="flex justify-normal">
                    <div>
                        <p>with address at</p>
                    </div>

                    <div class="underline" style="width:80%">
                        <span>Name Here</span>
                    </div>
                </div>
                <div class="flex justify-normal">
                    <div>
                        <p>Business Style</p>
                    </div>

                    <div class="underline" style="width:80%">
                        <span>Name Here</span>
                    </div>
                </div>

                <div class="flex justify-normal">
                    <div>
                        <p>with TIN</p>
                    </div>

                    <div class="underline" style="width:80%">
                        <span>Name Here</span>
                    </div>
                </div>


                <div class="flex justify-normal">
                    <div>
                        <p>with TIN</p>
                    </div>

                    <div class="underline" style="width:80%">
                        <span>the sum of pesos</span>
                    </div>
                </div>



                <div class="flex justify-normal">

                    <div class="underline" style="width:80%">
                        <span>the sum of pesos</span>
                    </div>
                </div>

                <div class="flex justify-normal">
                    <div>

                    </div>

                    <div>
                        by
                        <div class="underline">

                        </div>
                        <span>Cashier/Authorized Representative</span>
                    </div>
            </div>

        </div>
    </div>

    <div class="service-list">
        <table>
            <thead>
                <tr>
                    <th>IN PAYMENT OF THE FOLLOWING SERVICE/AMENITIES</th>
                    <th>QUANTITY</th>
                    <th>UNIT PRICE</th>
                    <th>AMOUNT</th>
                </tr>
            </thead>
        </table>
    </div>

</body>

</html>
