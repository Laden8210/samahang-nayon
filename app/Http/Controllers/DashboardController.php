<?php

namespace App\Http\Controllers;

use App\Models\CheckInOut;
use App\Models\Employee;
use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomNumber;
use Carbon\Carbon; // Import Carbon for date handling
use Illuminate\Http\Request;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index()
    {


        // Get the current date
        $today = Carbon::today();

        $totalRooms = RoomNumber::count();
        $occupiedRooms = Reservation::where('DateCheckIn', $today)
        ->whereIn('Status', ['Checked In', 'Booked', 'Reserved'])
        ->count();


        $availableRooms = $totalRooms - $occupiedRooms;

        // Only count reservations created today
        $totalBooking = Reservation::where('Status', 'Booked')
            ->whereDate('DateCreated', $today)
            ->count();

        $totalReservation = Reservation::where('Status', 'Reserved')
            ->whereDate('DateCreated', $today)
            ->count();

        $totalCheckIn = CheckInOut::where('Type', 'Checked In')
            ->whereDate('DateCreated', $today)
            ->count();

        $totalCheckOut = CheckInOut::where('Type', 'Checked Out')
            ->whereDate('DateCreated', $today)
            ->count();

        $user = CheckInOut::with('reservation', 'reservation.subGuests', 'guest')
            ->whereDate('DateCreated', $today)
            ->where('Type', 'Checked In')
            ->get();

            $totalGuests = $user->sum(function ($checkInOut) {

                $count = 1;


                if ($checkInOut->reservation && $checkInOut->reservation->subGuests) {
                    $count += $checkInOut->reservation->subGuests->count();
                }

                return $count;
            });



        $labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        // Initialize room occupancy data for all months with zeros
        $roomOccupancyData = array_fill(0, 12, 0);

        // Fetch occupancy data grouped by month
        $occupancyByMonth = CheckInOut::selectRaw('MONTH(DateCreated) as month, COUNT(*) as total')
            ->where('Type', 'Checked In')
            ->whereYear('DateCreated', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Fill roomOccupancyData with actual values where available
        foreach ($occupancyByMonth as $month => $total) {
            // Subtract 1 to match the zero-indexed array with the month number
            $roomOccupancyData[$month - 1] = $total;
        }


        return view('admin.dashboard.index', [
            'totalRooms' => $totalRooms,
            'occupiedRooms' => $occupiedRooms,
            'availableRooms' => $availableRooms,
            'totalBooking' => $totalBooking,
            'totalReservation' => $totalReservation,
            'user' => $totalGuests,
            'totalCheckIn' => $totalCheckIn,
            'totalCheckOut' => $totalCheckOut,
            'labels' => $labels,
            'roomOccupancyData' => $roomOccupancyData
        ]);
    }

    public function markAsRead($id)
    {
        $notification = Notification::find($id);

        if ($notification) {
            $notification->update(['status' => 'read']);
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error'], 404);
    }
}
