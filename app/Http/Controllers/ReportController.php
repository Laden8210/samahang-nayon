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

        if ($report->type === 'Guest History Report') {

            $reservations = Reservation::with(['guest', 'room', 'reservationAmenities', 'checkInOuts'])
                ->where('GuestId', $report->GuestId)
                ->get();

                $pdf = Pdf::loadView('admin.report.sales', compact('reservations', 'report'));
                return $pdf->stream('invoice.pdf');
        }else if($report->type === 'Arrival and Departure Report'){
            if ($report->EndDate) {
                // Fetch reservations where both DateCheckIn and DateCheckOut are within the date range
                $reservations = Reservation::with(['guest', 'room', 'reservationAmenities', 'checkInOuts'])
                    ->where(function ($query) use ($report) {
                        $query->whereBetween('DateCheckIn', [$report->Date, $report->EndDate])
                              ->orWhereBetween('DateCheckOut', [$report->Date, $report->EndDate]);
                    })
                    ->get();
            } else {
                // Only use the start date if EndDate is null, fetching reservations created on that date
                $reservations = Reservation::with(['guest', 'room', 'reservationAmenities', 'checkInOuts'])
                    ->whereDate('DateCreated', '=', $report->Date)
                    ->get();
            }


        }else {
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
        }



        $pdf = Pdf::loadView('admin.report.sales', compact('reservations', 'report'));
        return $pdf->stream('invoice.pdf');
    }
}
