<?php

namespace App\Livewire\Booking;

use App\Mail\SamahangNayonMailer;
use App\Models\Amenities;
use App\Models\DiscountedRoom;
use Livewire\Component;
use App\Models\Guest;
use App\Models\Promotion;
use App\Models\Room;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

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

    public $totalChildren;

    public $selectedAmenities = [];
    public $quantity = [];

    public $total;

    public $discountedRoomRate;
    public $paymentAmount;
    public $paymentType;

    public $availableRooms;

    public $discount;

    public $searchAmenity;

    public $subguests = [];


    public $subguestsFirstname;
    public $subguestsMiddlename;
    public $subguestsLastname;
    public $subguestsDob;
    public $subguestsGender;
    public $subguestsEmail;
    public $subguestsContactnumber;

    public $discountType;

    public $searchCustomer;


    public $apiProvince = [];
    public $apiCity = [];
    public $apiBrgy = [];
    public $selectedProvince = null;
    public $selectedCity = null;

    public $selectedBrgy = null;

    public $idNumber;
    public function mount()
    {
        $this->checkIn = Carbon::today()->format('Y-m-d');
        $this->checkOut = Carbon::today()->addDay()->format('Y-m-d');
        $this->availableRooms = $this->getAvailableRooms();
        $this->totalGuests = 1;
        $this->totalChildren = 0;
        $this->fetchRegions();
    }

    public function fetchRegions()
    {
        $this->apiProvince = Http::get('https://psgc.gitlab.io/api/provinces/')->json();
    }

    public function fetchCities()
    {
        if ($this->selectedProvince) {

            $this->apiCity = Http::get("https://psgc.gitlab.io/api/provinces/{$this->selectedProvince}/cities-municipalities/")->json();
        } else {
            $this->apiCity = [];
        }
    }

    public function fetchBarangays()
    {
        if ($this->selectedCity) {

            $this->apiBrgy = Http::get("https://psgc.gitlab.io/api/cities-municipalities/{$this->selectedCity}/barangays/")->json();
        } else {
            $this->apiBrgy = [];
        }
    }

    public function render()
    {
        return view('livewire.booking.create-booking', [
            'guests' => Guest::search($this->searchCustomer)->get(),

            'amenities' => Amenities::search($this->searchAmenity)->get(),
        ]);
    }

    public function updated($propertyName)
    {


        if (in_array($propertyName, ['checkOut', 'totalChildren', 'totalGuests'])) {
            $this->availableRooms = $this->getAvailableRooms();

        }

        if (in_array($propertyName, ['discountType'])) {

            $this->applyDiscount();
        }
    }

    public function addSubGuest()
    {
        $this->validate([
            'subguestsFirstname' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:255'],
            'subguestsLastname' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:255'],
            'subguestsDob' => 'required|date',
            'subguestsGender' => 'required',
            'subguestsEmail' => 'required|email',
            'subguestsContactnumber' => 'required|numeric',
        ]);


        $this->subguests[] = [
            'firstname' => $this->subguestsFirstname,
            'middlename' => $this->subguestsMiddlename,
            'lastname' => $this->subguestsLastname,
            'dob' => $this->subguestsDob,
            'gender' => $this->subguestsGender,
            'email' => $this->subguestsEmail,
            'contactnumber' => $this->subguestsContactnumber,
        ];
        session()->flash('subguest-message', 'Subguest added successfully.');
        $this->reset(['subguestsFirstname', 'subguestsMiddlename', 'subguestsLastname', 'subguestsDob', 'subguestsGender', 'subguestsEmail', 'subguestsContactnumber']);
    }

    public function removeSubGuest($index)
    {
        unset($this->subguests[$index]);
        $this->subguests = array_values($this->subguests);
        session()->flash('subguest-message', 'Subguest removed successfully.');
    }

    public function getAvailableRooms()
    {
        $checkIn = Carbon::parse($this->checkIn);
        $checkOut = Carbon::parse($this->checkOut);

        // Calculate total number of guests
        $totalChildren = is_null($this->totalChildren) ? 0 : (int)$this->totalChildren;
        $totalGuests = is_null($this->totalGuests) ? 0 : (int)$this->totalGuests;
        $total = $totalChildren + $totalGuests;

        // Get available rooms by excluding those that are booked during the desired check-in/check-out period
        $bookedRooms = Reservation::whereIn('Status', ['Checked In', 'Reserved', 'Booked'])
            ->where(function ($query) use ($checkIn, $checkOut) {

                $query->whereBetween('DateCheckIn', [$checkIn, $checkOut])
                    ->orWhereBetween('DateCheckOut', [$checkIn, $checkOut])
                    ->orWhere(function ($query) use ($checkIn, $checkOut) {
                        $query->where('DateCheckIn', '<=', $checkIn)
                            ->where('DateCheckOut', '>=', $checkOut);
                    });
            })
            ->select('RoomId')
            ->distinct()
            ->pluck('RoomId');


        $rooms = Room::where('Capacity', '>=', $total)
            ->get()
            ->values();

        $availableRooms = $rooms->reject(function ($room) use ($bookedRooms) {
            return $bookedRooms->contains($room->RoomId); // Compare with booked room IDs
        })->values();




        $discounted = Promotion::where('StartDate', '<=', $checkOut)
            ->where('EndDate', '>=', $checkIn)
            ->with('discountedRooms')
            ->first();


        if ($discounted && $discounted->discountedRooms->isNotEmpty()) {
            foreach ($availableRooms as $room) {
                // Check if the room is in the list of discounted rooms
                $discountedRoom = $discounted->discountedRooms->firstWhere('RoomId', $room->RoomId);

                if ($discountedRoom) {
                    // Apply the discount to the room
                    $room->Discount = $discounted->Discount; // Use discount from the promotion
                    $room->PromotionDescription = $discounted->Description;
                    $room->StartDate = $discounted->StartDate;
                    $room->EndDate = $discounted->EndDate;
                }
            }
        }

        return collect($availableRooms);
    }



    public function saveBooking()
    {




        $province = "";
        $city = "";
        $brgy = "";

        foreach ($this->apiProvince as $prov) {
            if ($prov['code'] == $this->selectedProvince) {
                $province = $prov['name'];
                break;
            }
        }

        foreach ($this->apiCity as $cit) {
            if ($cit['code'] == $this->selectedCity) {
                $city = $cit['name'];
                break;
            }
        }

        foreach ($this->apiBrgy as $b) {
            if ($b['code'] == $this->selectedBrgy) {
                $brgy = $b['name'];
                break;
            }
        }


        if ($this->selectedGuestId) {
            $guest = Guest::find($this->selectedGuestId);
        } else {


            $this->validate([
                'firstname' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:255'],
                'lastname' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:255'],
                'dob' => 'required|date',
                'gender' => 'required',
                'email' => 'required|email',
                'street' => 'required',
                'selectedBrgy' => 'required',
                'selectedCity' => 'required',
                'selectedProvince' => 'required',
                'contactnumber' => ['required', 'regex:/^(09|\+639)[0-9]{9}$/'],
            ]);
            if (
                $this->selectedGuestId || $this->firstname || $this->middlename || $this->lastname || $this->dob ||
                $this->gender || $this->email || $this->street || $this->brgy || $this->city ||
                $this->province || $this->contactnumber
            ) {
                $guest = new Guest();

                $guest->FirstName = $this->firstname;
                $guest->MiddleName = $this->middlename;
                $guest->LastName = $this->lastname;
                $guest->Birthdate = $this->dob;
                $guest->Gender = $this->gender;
                $guest->EmailAddress = $this->email;
                $guest->Street = $this->street;
                $guest->Brgy = $brgy;
                $guest->City = $city;
                $guest->Province = $province;
                $guest->ContactNumber = $this->contactnumber;
                $guest->Password = bcrypt('password');
                $guest->DateCreated = date('Y-m-d');
                $guest->TimeCreated = date('H:i:s');

                $guest->save();
            } else {
                session()->flash('message', 'Please select or enter the guest information.');
                return;
            }
        }

        if (!$this->selectedRoomId) {
            session()->flash('message', 'Please select the room first');
            return;
        }


        $room = Room::find($this->selectedRoomId);

        $totalAmenities = 0;

        foreach ($this->selectedAmenities as $amenity) {
            $totalAmenities += $amenity['price'] * $amenity['quantity'];
        }

        $reservation = new Reservation();
        $reservation->RoomId = $room->RoomId;
        $reservation->GuestId = $guest->GuestId;
        $reservation->DateCheckIn = $this->checkIn;
        $reservation->DateCheckOut = $this->checkOut;
        $reservation->TotalCost =  $this->discountedRoomRate - $totalAmenities;
        $reservation->Status = 'Booked';
        $reservation->Discount = ($room->RoomPrice * $this->lengthOfStay) - $this->discountedRoomRate;

        $reservation->OriginalCost =  $room->RoomPrice * $this->lengthOfStay;
        $reservation->TotalAdult = $this->totalGuests;
        $reservation->TotalChildren = $this->totalChildren ?? 0;
        $reservation->Source = 'Walk In';
        $reservation->DiscountType = $this->discountType;



        $purpose = "";

        if ($this->discountType == 'Senior Citizen') {
            $purpose = "Senior Citizen Discount";

            if ($this->idNumber == null) {
                session()->flash('message', 'Please enter the ID Number');
                return;
            }

            if (strlen($this->idNumber) != 12) {
                session()->flash('message', 'Invalid ID Number');
                return;
            }


            $reservation->IdNumber = $this->idNumber;
        } else if ($this->discountType == 'PWD') {
            $purpose = "PWD Discount";
            if ($this->idNumber == null) {
                session()->flash('message', 'Please enter the ID Number');
                return;
            }

            if (strlen($this->idNumber) != 12) {
                session()->flash('message', 'Invalid ID Number');
                return;
            }

            $reservation->IdNumber = $this->idNumber;
        } else if ($this->discountType == 'None') {
            $purpose = "No Discount";
        }

        $reservation->DateCreated = date('Y-m-d');
        $reservation->TimeCreated = date('H:i:s');


        $reservation->save();

        foreach ($this->subguests as $subguest) {
            $reservation->subguests()->create([
                'FirstName' => $subguest['firstname'],
                'MiddleName' => $subguest['middlename'],
                'LastName' => $subguest['lastname'],
                'Birthdate' => $subguest['dob'],
                'Gender' => $subguest['gender'],
                'EmailAddress' => $subguest['email'],
                'ContactNumber' => $subguest['contactnumber'],
            ]);
        }


        $reservation->reservationAmenities()->createMany(
            collect($this->selectedAmenities)->map(function ($amenity) {
                return [
                    'AmenitiesId' => $amenity['id'],
                    'Quantity' => $amenity['quantity'],
                    'TotalCost' => $amenity['price'] * $amenity['quantity'],
                ];
            })
        );

        if (!$this->paymentType) {
            session()->flash('message', 'Please select the payment method');
            return;
        }

        if ($this->paymentAmount != 0) {
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
        }


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


        $this->fetchRegions();

        foreach ($this->apiProvince as $prov) {
            if ($prov['name'] == $guest->Province) {
                $this->selectedProvince = $prov['code'];
                break;
            }
        }

        $this->fetchCities();

        foreach ($this->apiCity as $cit) {
            if ($cit['name'] == $guest->City) {
                $this->selectedCity = $cit['code'];
                break;
            }
        }

        $this->fetchBarangays();

        foreach ($this->apiBrgy as $b) {
            if ($b['name'] == $guest->Brgy) {
                $this->selectedBrgy = $b['code'];
                break;
            }
        }
    }

    public function updateAmenityQuantity($amenityId)
    {
        $amenity = Amenities::find($amenityId);

        if ($amenity) {
            $currentQuantity = $this->quantity[$amenityId] ?? 0;
            $newQuantity = $currentQuantity;

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

            $this->dispatch('close-modal');
            $this->total = $this->computeTotal();
        }
    }

    public function applyDiscount()
    {
        $checkIn = Carbon::parse($this->checkIn);
        $checkOut = Carbon::parse($this->checkOut);
        $this->lengthOfStay = $checkIn->diffInDays($checkOut);

        $this->total = $this->computeTotal();


        $promotions = Promotion::where('StartDate', '<=', $checkIn)
            ->where('EndDate', '>=', $checkOut)
            ->first();

        if ($promotions) {

            foreach ($promotions->discountedRooms as $discount) {
                if ($discount->RoomId === $this->selectedRoomId) {
                    $this->discount = $promotions;
                    break;
                }
            }


            if ($this->discount) {

                $this->discountedRoomRate = $this->total -  ($this->total * ($this->discount->Discount / 100));
            } else {

                if ($this->discountType != 'None') {
                    $this->discountedRoomRate = $this->total -  ($this->total * (10 / 100));
                } else {
                    $this->discountedRoomRate = $this->total;
                }
            }
        } else {
            if ($this->discountType != 'None') {
                $this->discountedRoomRate = $this->total -  ($this->total * (10 / 100));
            } else {
                $this->discountedRoomRate = $this->total;
            }
        }
    }


    public function selectRoom($roomId)
    {
        // Find the room
        $room = Room::find($roomId);
        $this->selectedRoom = $room;
        $this->selectedRoomId = $roomId;

        $this->dispatch('close-modal');

        $checkIn = Carbon::parse($this->checkIn);
        $checkOut = Carbon::parse($this->checkOut);
        $this->lengthOfStay = $checkIn->diffInDays($checkOut);

        $this->total = $this->computeTotal();


        $promotions = Promotion::where('StartDate', '<=', $checkIn)
            ->where('EndDate', '>=', $checkOut)
            ->first();

        if ($promotions) {

            foreach ($promotions->discountedRooms as $discount) {
                if ($discount->RoomId === $roomId) {
                    $this->discount = $promotions;
                    break;
                }
            }


            if ($this->discount) {

                $this->discountedRoomRate = $this->total -  ($this->total * ($this->discount->Discount / 100));
            } else {
                $this->discountedRoomRate = $this->total;
            }
        } else {
            $this->discountedRoomRate = $this->total;
        }
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
