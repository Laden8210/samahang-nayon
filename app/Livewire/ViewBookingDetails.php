<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Reservation;
class ViewBookingDetails extends Component
{
    public $ReservationId;
    public $reservation;
    public function render()
    {
        return view('livewire.view-booking-details');
    }
    public function mount($ReservationId)
    {
        $this->ReservationId = $ReservationId;
        $this->reservation = Reservation::find($ReservationId);
    }
}
