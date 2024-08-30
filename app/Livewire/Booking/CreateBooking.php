<?php

namespace App\Livewire\Booking;

use App\Models\Amenities;
use Livewire\Component;
use App\Models\Guest;
use App\Models\Room;
use App\Models\Reservation;
use Carbon\Carbon;

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
    public $lengthOfStay;

    public $checkIn;
    public $checkOut;
    public $totalGuests;

    public $selectedAmenities = [];
    public $quantity = [];

    public $total;
    public $paymentAmount;

    public function render()
    {
        return view('livewire.booking.create-booking', [
            'guests' => Guest::all(),
            'rooms' => Room::all(),
            'amenities' => Amenities::all(),
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
            $guest->Brgy = $this->brgy;
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
        $reservation->Disburse = $this->total;

        $purpose="";
        if ($this->paymentAmount) {
            $reservation->Balance = $this->total - $this->paymentAmount;
        } else {
            $reservation->Balance = $this->total;
        }

        if ($this->paymentAmount >= $this->total) {
            $reservation->Status = 'Booked';
            $purpose = 'Full Payment';
        } elseif ($this->paymentAmount >= 0.3 * $this->total) {

            $reservation->Status = 'Reserved';
            $purpose = 'Partial Payment';
        } else {
            $reservation->Status = 'Unpaid';
            $purpose = 'Partial Payment';
        }
        $reservation->DateCreated = date('Y-m-d');
        $reservation->TimeCreated = date('H:i:s');
        $reservation->save();

        $reservation->reservationAmenities()->createMany(
            collect($this->selectedAmenities)->map(function ($amenity) {
                return [
                    'AmenitiesId' => $amenity['id'],
                    'Quantity' => $amenity['quantity'],
                ];
            })
        );
        $reservation->payments()->create([
            'GuestId' => $guest->GuestId,
            'AmountPaid' => $this->paymentAmount,
            'DateCreated' => date('Y-m-d'),
            'TimeCreated' => date('H:i:s'),
            'Status' => 'Confirmed`',
            'PaymentType' => 'Cash',
            'ReferenceNumber' => $this->generateReferenceNumber(),
            'Purpose' => $purpose,

        ]);
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

    public function selectAmenity($amenityId, $quantity)
    {
        $amenity = Amenities::find($amenityId);

        if ($amenity && $quantity > 0) {

            $index = collect($this->selectedAmenities)->search(fn($item) => $item['id'] === $amenity->AmenitiesId);

            if ($index !== false) {

                $this->selectedAmenities[$index]['quantity'] = $quantity;
            } else {

                $this->selectedAmenities[] = [
                    'id' => $amenity->AmenitiesId,
                    'name' => $amenity->Name,
                    'price' => $amenity->Price,
                    'quantity' => $quantity,
                ];
            }

            $this->total = $this->computeTotal();
        }
    }



    public function selectRoom($roomId)
    {
        $room = Room::find($roomId);
        $this->selectedRoom = $room->RoomType . ' - ' . $room->RoomNumber;
        $this->selectedRoomId = $roomId;
        $this->dispatch('close-modal');

        $checkIn = Carbon::parse($this->checkIn);
        $checkOut = Carbon::parse($this->checkOut);
        $this->lengthOfStay = $checkIn->diffInDays($checkOut);
        $this->total = $this->computeTotal();
    }

    public function computeTotal()
    {

        $room = Room::find($this->selectedRoomId);

        if ($room) {
            $total = $room->RoomPrice * $this->lengthOfStay;
        }


        $total = 0;
        foreach ($this->selectedAmenities as $amenity) {
            $total += $amenity['price'] * $amenity['quantity'];
        }
        return $total;
    }

    public function generateReferenceNumber()
    {
        return 'REF-' . date('YmdHis');
    }
}
