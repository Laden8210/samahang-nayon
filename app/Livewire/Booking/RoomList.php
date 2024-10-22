<?php

namespace App\Livewire\Booking;

use App\Models\Reservation;
use Livewire\Component;
use App\Models\Room;
use App\Models\RoomNumber;
use App\Models\Promotion;
use Carbon\Carbon;

class RoomList extends Component
{
    public function render()
    {
        // Fetch all room numbers
        $roomNumbers = RoomNumber::all();

        // Get the current date using Carbon
        $currentDate = Carbon::today();

        // Find the current promotion that is active
        $promotion = Promotion::where('StartDate', '<=', $currentDate)
                                ->where('EndDate', '>=', $currentDate)
                                ->first();


        if ($promotion && $promotion->discountedRooms) {
            foreach ($roomNumbers as $roomNumber) {
                foreach ($promotion->discountedRooms as $discountedRoom) {
                    if ($discountedRoom->RoomId == $roomNumber->RoomId) {
                        $roomNumber->discount = $promotion->Discount;
                    }
                }
            }
        }


        $reservation = Reservation::where('DateCheckIn', '<=', $currentDate)
                                    ->where('DateCheckOut', '>=', $currentDate)
                                    ->get();

        foreach ($roomNumbers as $roomNumber) {
            $roomNumber->isBooked = false;
            foreach ($reservation as $res) {
                if ($res->room_number_id == $roomNumber->room_number_id) {
                    $roomNumber->isBooked = true;
                }
            }
        }
        return view('livewire.booking.room-list', [
            'roomNumbers' => $roomNumbers
        ]);
    }
}
