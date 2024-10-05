<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReceiptExport;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Reservation;
use PhpOffice\PhpSpreadsheet\Writer\Html;


class ReceiptController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve the payment record based on the reference number
        $payment = Payment::where('ReferenceNumber', $request->view)->first();

        // Generate the PDF using the payment details
        if ($payment != null) {
            $amountInWords = $this->convertNumberToWords($payment->AmountPaid);
            $pdf = Pdf::loadView('receipt.index', compact('payment', 'amountInWords'));

            return $pdf->stream($request->view . '.pdf');
        }

        return redirect()->route('index');
    }

    function convertNumberToWords($number)
    {
        $words = '';

        $units = [
            '',
            'one',
            'two',
            'three',
            'four',
            'five',
            'six',
            'seven',
            'eight',
            'nine',
            'ten',
            'eleven',
            'twelve',
            'thirteen',
            'fourteen',
            'fifteen',
            'sixteen',
            'seventeen',
            'eighteen',
            'nineteen'
        ];

        $tens = [
            '',
            '',
            'twenty',
            'thirty',
            'forty',
            'fifty',
            'sixty',
            'seventy',
            'eighty',
            'ninety'
        ];

        if ($number < 0) {
            $words = 'negative ';
            $number = abs($number);
        }

        if ($number < 20) {
            $words .= $units[$number];
        } elseif ($number < 100) {
            $words .= $tens[intval($number / 10)];
            if ($number % 10) {
                $words .= '-' . $units[$number % 10];
            }
        } elseif ($number < 1000) {
            $words .= $units[intval($number / 100)] . ' hundred';
            if ($number % 100) {
                $words .= ' and ' . $this->convertNumberToWords($number % 100);
            }
        } elseif ($number < 1000000) {
            $words .= $this->convertNumberToWords(intval($number / 1000)) . ' thousand';
            if ($number % 1000) {
                $words .= ' ' . $this->convertNumberToWords($number % 1000);
            }
        } else {
            $words .= $this->convertNumberToWords(intval($number / 1000000)) . ' million';
            if ($number % 1000000) {
                $words .= ' ' . $this->convertNumberToWords($number % 1000000);
            }
        }

        return trim($words);
    }

    public function printReceipt(Request $request)
    {
        // Load your predefined template
        $spreadsheet = IOFactory::load(storage_path('app/template.xlsx'));
        $sheet = $spreadsheet->getActiveSheet();

        // Fetch data from the database
        $reservations = Reservation::all();

        // Inject data into specific cells
        foreach ($reservations as $index => $reservation) {
            // Assuming you want to fill data starting from row 6
            $row = $index + 6; // Replace 6 with the actual starting row for data


            $amenityRow = 19; // Initialize the row for amenities

            // Loop through each reservation's amenities
            foreach ($reservation->reservationAmenities as $reservationAmenity) {
                // Fill the amenities data starting from row 19
                $sheet->setCellValue("B$amenityRow", $reservationAmenity->amenity->Name);
                $sheet->setCellValue("G$amenityRow", $reservationAmenity->Quantity);
                $sheet->setCellValue("k$amenityRow", $reservationAmenity->amenity->Price);
                $sheet->setCellValue("p$amenityRow", $reservationAmenity->TotalCost);
                // Increment the amenity row for the next amenity
                $amenityRow++;
            }
        }

        // Create a writer to convert the spreadsheet to HTML
        $writer = new Html($spreadsheet);

        // Set headers for HTML output
        header('Content-Type: text/html');
        header('Content-Disposition: inline; filename="receipts.html"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        // Start output buffering
        ob_start();
        $writer->save('php://output');
        $htmlOutput = ob_get_clean();

        // Return HTML response
        return response($htmlOutput, 200)
            ->header('Content-Type', 'text/html');
    }
}
