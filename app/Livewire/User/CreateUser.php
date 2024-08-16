<?php

namespace App\Livewire\User;


use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\UserAccount;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUser extends Component
{

    public $firstname;
    public $middlename;
    public $lastname;
    public $contactNumber;
    public $email;
    public $street;
    public $city;
    public $province;
    public $dob;
    public $gender;
    public $position;


    public function createUser()
    {
        $this->validate(
            [
                'firstname' => 'required|string|max:255',
                'middlename' => 'nullable|string|max:255',
                'lastname' => 'required|string|max:255',
                'contactNumber' => 'required|string|max:15',
                'email' => 'required|email|unique:users,email',
                'street' => 'nullable|string|max:255',
                'city' => 'required|string|max:255',
                'province' => 'required|string|max:255',
                'dob' => 'required|date',
                'gender' => ['required', Rule::in(['Male', 'Female'])],
                'position' => ['required', Rule::in(['System Administrator', 'Manager', 'Receptionist'])],
            ]
        );

        $birthdate = new \DateTime($this->dob);
        $month = $birthdate->format('m');
        $day = $birthdate->format('d');
        $year = $birthdate->format('Y');

        $defaultPassword = Str::lower($this->lastname) . $month . $day . $year;

        $user = UserAccount::create([
            'Username' => $this->email,
            'EmailAddress' => $this->email,
            'Password' => Hash::make($defaultPassword),
            'AccountType' => 'User',
            'Status' => 'Active',
            'DateCreated' => now()->format('Y-m-d'),
            'TimeCreated' => now()->format('H:i:s'),
        ]);

        $user->employees()->create([
            'FirstName' => $this->firstname,
            'MiddleName' => $this->middlename,
            'LastName' => $this->lastname,
            'ContactNumber' => $this->contactNumber,
            'EmailAddress' => $this->email,
            'Street' => $this->street,
            'City' => $this->city,
            'Province' => $this->province,
            'Birthdate' => $this->dob,
            'Gender' => $this->gender,
            'Position' => $this->position,
            'Status' => 'Active',
        ]);

        session()->flash('message', 'User created successfully!');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.user.create-user');
    }
}
