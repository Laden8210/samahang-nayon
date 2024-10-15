<?php

namespace App\Livewire\Booking;

use App\Models\Reservation;
use Livewire\Component;
use App\Models\Room;

class RoomList extends Component
{
    public function render()
    {
        $rooms = Room::orderBy('RoomNumber', 'asc')->get();

        // Get all rooms that are currently reserved
        $reservedRoomIds = Reservation::where('DateCheckIn', '<=', date('Y-m-d'))
            ->where('DateCheckOut', '>=', date('Y-m-d'))
            ->pluck('RoomId') // Only get the RoomId of reserved rooms
            ->toArray(); // Convert the collection to an array

        foreach ($rooms as $room) {
            // If the room is in the list of reserved rooms, mark it as 'Not Available'
            if (in_array($room->RoomId, $reservedRoomIds)) {
                $room->RoomStatus = 'Not Available';
            } else {
                $room->RoomStatus = 'Available';
            }
        }



        return view('livewire.booking.room-list', [
            'rooms' => $rooms
        ]);
    }

}
