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
use Illuminate\Support\Facades\Auth;

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

    public function printReceipt($id)
    {

        $spreadsheet = IOFactory::load(storage_path('app/template.xlsx'));
        $sheet = $spreadsheet->getActiveSheet();


        $reservation = Reservation::find($id);


        $totalPayment = 0;


        $amenityRow = 20;

        $lenghtOfStay = Carbon::parse($reservation->DateCheckIn)->diffInDays(Carbon::parse($reservation->DateCheckOut));

        $sheet->setCellValue('B19', $reservation->room->RoomType);
        $sheet->setCellValue('G19', $lenghtOfStay);
        $sheet->setCellValue('K19', $reservation->room->RoomPrice);
        $sheet->setCellValue('P19', $reservation->room->RoomPrice * $lenghtOfStay);

        foreach ($reservation->reservationAmenities as $reservationAmenity) {

            $sheet->setCellValue("B$amenityRow", $reservationAmenity->amenity->Name);
            $sheet->setCellValue("G$amenityRow", $reservationAmenity->Quantity);
            $sheet->setCellValue("k$amenityRow", $reservationAmenity->amenity->Price);
            $sheet->setCellValue("p$amenityRow", $reservationAmenity->TotalCost);

            $amenityRow++;
        }

        foreach($reservation->payments as $payment){
            $totalPayment += $payment->AmountPaid;
        }


        $amountInWords = $this->convertNumberToWords($payment->AmountPaid);

        $sheet->setCellValue('O7',  Carbon::now()->toDateString());
        $sheet->setCellValue('f9',  "with address at ". $reservation->guest->Street . ', ' . $reservation->guest->Brgy . ', ' . $reservation->guest->City . ', ' . $reservation->guest->Province);
        $sheet->setCellValue('f8', "Received from: ". $reservation->guest->FirstName . ' ' . $reservation->guest->LastName);
        $employee = Auth::user();

        $sheet->setCellValue('O14', $employee->FirstName . ' ' . $employee->LastName);

        $sheet->setCellValue('F11', $amountInWords);

        $sheet->setCellValue('F10', $totalPayment);

        $writer = new Html($spreadsheet);


        header('Content-Type: text/html');
        header('Content-Disposition: inline; filename="receipts.html"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        ob_start();
        $writer->save('php://output');
        $htmlOutput = ob_get_clean();

        // Return HTML response
        return response($htmlOutput, 200)
            ->header('Content-Type', 'text/html');
    }


    public function success($reference)
    {
        $payment = Payment::where('ReferenceNumber', $reference)->first();
        $payment->update(['Status' => 'Confirmed']);
        return view('receipt.success', compact('reference'));
    }


    public function failed($reference)
    {
        $payment = Payment::where('ReferenceNumber', $reference)->first();

        return view('receipt.failed');
    }
}
