<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReceiptController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve the payment record based on the reference number
        $payment = Payment::where('ReferenceNumber', $request->view)->first();

        // Generate the PDF using the payment details
        $amountInWords = $this->convertNumberToWords($payment->AmountPaid);
        $pdf = Pdf::loadView('receipt.index', compact('payment', 'amountInWords'));

        return $pdf->stream($request->view . '.pdf');
    }

    function convertNumberToWords($number) {
        $words = '';

        $units = [
            '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine',
            'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen',
            'seventeen', 'eighteen', 'nineteen'
        ];

        $tens = [
            '', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'
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

}
