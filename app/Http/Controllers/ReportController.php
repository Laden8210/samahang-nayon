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

    public function downloadReport($id)
    {
        $report = Report::find($id);

        if (!$report) {
            abort(404, 'Report not found');
        }

        // Handle the case where EndDate might be null
        if ($report->EndDate) {
            $reservations = Reservation::with(['guest', 'room', 'reservationAmenities', 'checkInOuts'])
                ->whereBetween('DateCreated', [$report->Date, $report->EndDate])
                ->get();
        } else {
            // Only use the start date if EndDate is null
            $reservations = Reservation::with(['guest', 'room', 'reservationAmenities', 'checkInOuts'])
                ->whereDate('DateCreated', '=', $report->Date)
                ->get();
        }

        if ($reservations->isEmpty()) {
            dd('No reservations found for the given date range');
        }

        $pdf = Pdf::loadView('admin.report.sales', compact('reservations', 'report'));
        return $pdf->stream('invoice.pdf');
    }


}
