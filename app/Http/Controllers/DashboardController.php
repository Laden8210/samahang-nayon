<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Reservation;
use App\Models\Room; // Assuming you have a Room model

class DashboardController extends Controller
{
    public function index()
    {
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $totalBooking = Reservation::where('Status', 'Booked')->count();
        $totalReservation = Reservation::where('Status', 'Reserved')->count();

        $availableRooms = $totalRooms - $occupiedRooms;

        $user = Employee::where('Status', 'Active')->count();

        // Fetch other necessary data...

        return view('admin.dashboard.index', [
            'totalRooms' => $totalRooms,
            'occupiedRooms' => $occupiedRooms,
            'availableRooms' => $availableRooms,
            'totalBooking' => $totalBooking,
            'totalReservation' => $totalReservation,
            'user' => $user,

        ]);
    }
}
