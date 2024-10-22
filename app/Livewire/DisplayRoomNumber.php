<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Room;
use App\Models\RoomNumber;

class DisplayRoomNumber extends Component
{

    public $displayRoomNumberModal = false;
    public $roomNumber;

    public $selectedRoom;


    public function render()
    {

        $rooms = Room::all();

        return view(
            'livewire.display-room-number',
            [
                'rooms' => $rooms,
                'roomNumbers' => RoomNumber::all()
            ]
        );
    }

    public function viewModal($roomNumber)
    {
        $this->displayRoomNumberModal = true;
        $this->roomNumber = $roomNumber;
    }

    public function closeModal()
    {
        $this->displayRoomNumberModal = false;
    }
    public function saveRoom()
    {
        $this->validate([
            'selectedRoom' => 'required'
        ]);

        $existingRoom = RoomNumber::where('room_number', $this->roomNumber)
            ->where('RoomId', $this->selectedRoom)->first();

        if ($existingRoom) {

            session()->flash('error', 'This room number already exists.');
            return;
        }

        RoomNumber::create([
            'RoomId' => $this->selectedRoom,
            'room_number' => $this->roomNumber
        ]);

        // Optionally, you can set a success message
        session()->flash('success', 'Room number saved successfully.');
    }
}
