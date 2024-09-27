<?php

namespace App\Livewire\Booking;

use App\Mail\SamahangNayonMailer;
use App\Models\Amenities;
use Livewire\Component;
use App\Models\Guest;
use App\Models\Room;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

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
    public $paymentType;

    public $availableRooms;

    public function mount()
    {
        $this->checkIn = Carbon::today()->format('Y-m-d');
        $this->checkOut = Carbon::today()->addDay()->format('Y-m-d');  // Default to one day after check-in
        $this->availableRooms = $this->getAvailableRooms();
    }

    public function render()
    {
        return view('livewire.booking.create-booking', [
            'guests' => Guest::all(),
            'rooms' => $this->availableRooms,  // Use available rooms here
            'amenities' => Amenities::all(),
        ]);
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'checkIn' || $propertyName === 'checkOut') {
            $this->availableRooms = $this->getAvailableRooms();
        }
    }

    public function getAvailableRooms()
    {
        $checkIn = Carbon::parse($this->checkIn);
        $checkOut = Carbon::parse($this->checkOut);



        return Room::leftJoin('reservations', 'rooms.RoomId', '=', 'reservations.RoomId')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereNull('reservations.RoomId')  // Rooms with no reservations
                    ->orWhere('reservations.Status', 'Checked Out') // Rooms that have been checked out
                    ->orWhere(function ($query) use ($checkIn, $checkOut) {
                        $query->where('reservations.DateCheckOut', '<', $checkIn)
                            ->orWhere('reservations.DateCheckIn', '>', $checkOut);
                    });
            })
            ->select('rooms.*')
            ->distinct()
            ->get();
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
        $reservation->TotalCost =  $room->RoomPrice * $this->lengthOfStay;
        $reservation->Status = 'Booked';
        $reservation->TotalAdult = $this->totalGuests;
        $reservation->TotalChildren = 0;

        $purpose = "";

        $reservation->DateCreated = date('Y-m-d');
        $reservation->TimeCreated = date('H:i:s');
        $reservation->save();

        $reservation->reservationAmenities()->createMany(
            collect($this->selectedAmenities)->map(function ($amenity) {
                return [
                    'AmenitiesId' => $amenity['id'],
                    'Quantity' => $amenity['quantity'],
                    'TotalCost' => $amenity['price'] * $amenity['quantity'],
                ];
            })
        );

        $reservation->payments()->create([
            'GuestId' => $guest->GuestId,
            'AmountPaid' => $this->paymentAmount ?? 0,
            'DateCreated' => date('Y-m-d'),
            'TimeCreated' => date('H:i:s'),
            'Status' => 'Confirmed`',
            'PaymentType' => $this->paymentType,
            'ReferenceNumber' => $this->generateReferenceNumber(),
            'Purpose' => $purpose,
        ]);
        $this->reset();

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

    public function updateAmenityQuantity($amenityId, $change)
    {
        $amenity = Amenities::find($amenityId);

        if ($amenity) {
            $currentQuantity = $this->quantity[$amenityId] ?? 0;
            $newQuantity = $currentQuantity + $change;

            if ($newQuantity > 0) {
                $index = collect($this->selectedAmenities)->search(fn($item) => $item['id'] === $amenityId);

                if ($index !== false) {
                    $this->selectedAmenities[$index]['quantity'] = $newQuantity;
                } else {
                    $this->selectedAmenities[] = [
                        'id' => $amenityId,
                        'name' => $amenity->Name,
                        'price' => $amenity->Price,
                        'quantity' => $newQuantity,
                    ];
                }
            } else {
                $this->selectedAmenities = array_filter($this->selectedAmenities, fn($item) => $item['id'] !== $amenityId);
            }

            $this->quantity[$amenityId] = $newQuantity > 0 ? $newQuantity : null;
            $this->total = $this->computeTotal();
        }
    }






    public function selectRoom($roomId)
    {
        $room = Room::find($roomId);
        $this->selectedRoom = $room;
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
            $this->total = $room->RoomPrice * $this->lengthOfStay;
        }

        foreach ($this->selectedAmenities as $amenity) {
            $this->total += $amenity['price'] * $amenity['quantity'];
        }
        return $this->total;
    }

    public function generateReferenceNumber()
    {
        return 'REF-' . date('YmdHis');
    }
}
