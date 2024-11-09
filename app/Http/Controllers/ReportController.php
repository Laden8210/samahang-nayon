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

            $reservations = Reservation::with(['guest', 'roomNumber', 'reservationAmenities', 'checkInOuts'])
                ->where('GuestId', $report->GuestId)
                ->where(function ($query) use ($report) {
                    $query->whereBetween('DateCheckIn', [$report->Date, $report->EndDate])
                        ->orWhereBetween('DateCheckOut', [$report->Date, $report->EndDate]);
                })
                ->get();
        } else if ($report->type === 'Arrival and Departure Report') {
            if ($report->EndDate) {
                // Fetch reservations where both DateCheckIn and DateCheckOut are within the date range
                $reservations = Reservation::with(['guest', 'roomNumber', 'reservationAmenities', 'checkInOuts'])
                    ->where(function ($query) use ($report) {
                        $query->whereBetween('DateCheckIn', [$report->Date, $report->EndDate])
                            ->orWhereBetween('DateCheckOut', [$report->Date, $report->EndDate]);
                    })
                    ->get();

                $arrival = Reservation::with(['guest', 'roomNumber', 'reservationAmenities', 'checkInOuts'])
                    ->where(function ($query) use ($report) {
                        $query->whereBetween('DateCheckIn', [$report->Date, $report->EndDate]);
                    })
                    ->get();

                    $departure = Reservation::with(['guest', 'roomNumber', 'reservationAmenities', 'checkInOuts'])
                    ->where(function ($query) use ($report) {
                        $query->whereBetween('DateCheckOut', [$report->Date, $report->EndDate]);
                    })
                    ->get();;

                    $pdf = Pdf::loadView('admin.report.sales', compact('reservations', 'report', 'arrival', 'departure'));
                    return $pdf->stream($report->type . '.pdf');

            } else {
                // Only use the start date if EndDate is null, fetching reservations created on that date
                $reservations = Reservation::with(['guest', 'roomNumber', 'reservationAmenities', 'checkInOuts'])
                    ->whereDate('DateCheckIn', '=', $report->Date)
                    ->get();
            }
        } else {
            $reservations = Reservation::with(['guest', 'roomNumber', 'reservationAmenities', 'checkInOuts'])
                ->when($report->EndDate, function ($query) use ($report) {
                    // Use the date range if EndDate is present
                    return $query->whereBetween('DateCreated', [$report->Date, $report->EndDate]);
                }, function ($query) use ($report) {
                    // Otherwise, only use the start date
                    return $query->whereDate('DateCreated', '=', $report->Date);
                })
                ->get();
        }

        $pdf = Pdf::loadView('admin.report.sales', compact('reservations', 'report'));
        return $pdf->stream($report->type . '.pdf');
    }
}
