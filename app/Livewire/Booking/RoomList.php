<?php

namespace App\Livewire\Booking;

use Livewire\Component;
use App\Models\Room;

class RoomList extends Component
{
    public function render()
    {
        return view('livewire.booking.room-list', [
            'rooms' => Room::orderBy('RoomNumber', 'asc')->get()
        ]);
    }
}
