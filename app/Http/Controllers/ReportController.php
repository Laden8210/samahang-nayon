<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
class ReportController extends Controller
{
    public function index()
    {
        return view('admin.report.index');
    }

    public function downloadReport($id){

        $report = Report::find($id);

        $reservations = Reservation::with(['guest', 'room', 'reservationAmenities', 'checkInOuts'])
        ->whereBetween('DateCreated', [$report->Date, $report->EndDate])
        ->get();

        // dd($reservations);

        $pdf = Pdf::loadView('admin.report.sales', compact('reservations', 'report'));
        return $pdf->stream('invoice.pdf');
    }

}
