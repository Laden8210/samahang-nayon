<?php

namespace App\Livewire\Booking;

use Livewire\Component;
use App\Models\Guest;

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

    public function render()
    {
        return view('livewire.booking.create-booking');
    }

    public function saveBooking(){


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
        $guest->UserAccountId = 2;

        $guest->save();

        session()->flash('message', 'Room Booking created successfully.');

    }
}
