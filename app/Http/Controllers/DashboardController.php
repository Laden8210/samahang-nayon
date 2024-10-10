<?php

namespace App\Http\Controllers;

use App\Models\CheckInOut;
use App\Models\Employee;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon; // Import Carbon for date handling

class DashboardController extends Controller
{
    public function index()
    {
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $availableRooms = $totalRooms - $occupiedRooms;

        // Get the current date
        $today = Carbon::today();

        // Only count reservations created today
        $totalBooking = Reservation::where('Status', 'Booked')
            ->whereDate('DateCreated', $today)
            ->count();
        $totalReservation = Reservation::where('Status', 'Reserved')
            ->whereDate('DateCreated', $today)
            ->count();

        $totalCheckIn = CheckInOut::where('Type', 'Check In')
            ->whereDate('DateCreated', $today)
            ->count();

        $totalCheckOut = CheckInOut::where('Type', 'Check Out')
            ->whereDate('DateCreated', $today)
            ->count();

        $user = Employee::where('Status', 'Active')->count();

        return view('admin.dashboard.index', [
            'totalRooms' => $totalRooms,
            'occupiedRooms' => $occupiedRooms,
            'availableRooms' => $availableRooms,
            'totalBooking' => $totalBooking,
            'totalReservation' => $totalReservation,
            'user' => $user,
            'totalCheckIn' => $totalCheckIn,
            'totalCheckOut' => $totalCheckOut,
        ]);
    }
}
