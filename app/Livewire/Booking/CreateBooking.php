<?php

namespace App\Livewire\Booking;

use Livewire\Component;
use App\Models\Guest;
use App\Models\Room;
use App\Models\Reservation;

class CreateBooking extends Component
{
    public $firstname;
    public $lastname;
    public $middlename;
    public $dob;
    public $gender;
    public $email;
    public $contactnumber;
    public $street;
    public $brgy;
    public $city;
    public $province;

    public $selectedRoom;
    public $selectedGuestId;
    public $selectedRoomId;

    public $checkIn;
    public $checkOut;
    public $totalGuests;

    public function render()
    {
        return view('livewire.booking.create-booking', [
            'guests' => Guest::all(),
            'rooms' => Room::all()
        ]);
    }

    public function saveBooking()
    {
        if ($this->selectedGuestId) {
            $guest = Guest::find($this->selectedGuestId);
        } else {
            $guest = new Guest();

            $guest->FirstName = $this->firstname;
            $guest->MiddleName = $this->middlename;
            $guest->LastName = $this->lastname;
            $guest->Birthdate = $this->dob;
            $guest->Gender = $this->gender;
            $guest->EmailAddress = $this->email;
            $guest->Street = $this->street;
            $guest->City = $this->city;
            $guest->Province = $this->province;
            $guest->ContactNumber = $this->contactnumber;
            $guest->Password = bcrypt('password');
            $guest->DateCreated = date('Y-m-d');
            $guest->TimeCreated = date('H:i:s');

            $guest->save();
        }

        $room = Room::find($this->selectedRoomId);

        $reservation = new Reservation();
        $reservation->RoomId = $room->RoomId;
        $reservation->GuestId = $guest->GuestId;
        $reservation->DateCheckIn = $this->checkIn;
        $reservation->DateCheckOut = $this->checkOut;
        $reservation->Disburse = 0;
        $reservation->Balance = 0;
        $reservation->Status = 'Pending';
        $reservation->DateCreated = date('Y-m-d');
        $reservation->TimeCreated = date('H:i:s');
        $reservation->save();
        session()->flash('message', 'Room Booking created successfully.');
    }

    public function filterRoom()
    {
        $this->validate([
            'checkIn' => 'required|date',
            'checkOut' => 'required|date|after:checkIn',
            'totalGuests' => 'required|integer|min:1',
        ]);
    }

    public function selectGuest($guestId)
    {
        $guest = Guest::find($guestId);

        $this->firstname = $guest->FirstName;
        $this->middlename = $guest->MiddleName;
        $this->lastname = $guest->LastName;
        $this->dob = $guest->Birthdate;
        $this->street = $guest->Street;
        $this->city = $guest->City;
        $this->province = $guest->Province;
        $this->contactnumber = $guest->ContactNumber;
        $this->email = $guest->EmailAddress;
        $this->gender = $guest->Gender;
        $this->dispatch('close-modal');
        $this->selectedGuestId = $guestId;
    }

    public function selectRoom($roomId)
    {
        $room = Room::find($roomId);
        $this->selectedRoom = $room->RoomType . ' - ' . $room->RoomNumber;
        $this->selectedRoomId = $roomId;
        $this->dispatch('close-modal');
    }
}
