<?php

namespace App\Livewire\Booking;

use Livewire\Component;

use App\Models\Reservation;

class BookingTable extends Component
{
    public function render()
    {
        return view('livewire.booking.booking-table', [
            'bookings' => Reservation::paginate(10)
        ]);
    }
}
