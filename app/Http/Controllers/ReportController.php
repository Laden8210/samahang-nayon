<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Reservation;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.report.index');
    }

    public function downloadReport($id){

        $reservations = Reservation::with(['guest', 'room', 'reservationAmenities'])->get();

        $pdf = Pdf::loadView('admin.report.sales', compact('reservations'));
        return $pdf->stream('invoice.pdf');
    }

}
