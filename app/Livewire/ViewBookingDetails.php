<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Reservation;
use Xendit\Refund\Refund;

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

    public function checkIn(){

        if($this->reservation->DateCheckIn > now()){
            session()->flash('message', 'Guest Cannot be Checked In Yet');
            return;
        }

        if($this->reservation->DateCheckOut < now()){
            session()->flash('message', 'Guest Cannot be Checked In Anymore');
            return;
        }

        if($this->reservation->Status == 'Checked Out'){
            session()->flash('message', 'Guest Already Checked Out');
            return;
        }

        if($this->reservation->Status == 'Checked In'){
            session()->flash('message', 'Guest Already Checked In');
            return;
        }


        $this->reservation->Status = 'Checked In';
        $this->reservation->save();
        $this->reservation->checkInOuts()->create([
            'GuestId' => $this->reservation->GuestId,
            'DateCreated' => now(),
            'TimeCreated' => now(),
            'Type' => 'Checked In'
        ]);
        session()->flash('message', 'Guest Checked In');
    }

    public function checkOut(){



        $this->reservation->Status = 'Checked Out';
        $this->reservation->save();
        $this->reservation->checkInOuts()->create([
            'GuestId' => $this->reservation->GuestId,
            'DateCreated' => now(),
            'TimeCreated' => now(),
            'Type' => 'Checked Out'
        ]);

        session()->flash('message', 'Guest Checked Out');

    }
}
