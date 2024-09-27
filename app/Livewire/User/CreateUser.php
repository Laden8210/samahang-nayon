<?php

namespace App\Livewire\User;

use App\Models\Employee;
use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\UserAccount;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Rules\Age;

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
    public $brgy;


    public function createUser()
    {
        $this->validate(
            [
                'firstname' => 'required|string|max:255',
                'middlename' => 'nullable|string|max:255',
                'lastname' => 'required|string|max:255',
                'contactNumber' => [
                    'required',
                    'string',
                    'max:12',
                    'regex:/^(?:\+63|0)9\d{9}$/',
                ],
                'email' => 'required|email|unique:employees,email',
                'street' => 'required|string|max:255',
                'brgy' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'province' => 'required|string|max:255',
                'dob' => ['required', 'date',new Age],
                'gender' => ['required', Rule::in(['Male', 'Female'])],
                'position' => ['required', Rule::in(['System Administrator', 'Manager', 'Receptionist'])],
            ],

        );

        $birthdate = new \DateTime($this->dob);
        $month = $birthdate->format('m');
        $day = $birthdate->format('d');
        $year = $birthdate->format('Y');

        $defaultPassword = Str::lower($this->lastname) . $month . $day . $year;



        Employee::create([
            'FirstName' => $this->firstname,
            'MiddleName' => $this->middlename,
            'LastName' => $this->lastname,
            'ContactNumber' => $this->contactNumber,
            'email' => $this->email,
            'Street' => $this->street,
            'Brgy' => $this->brgy,
            'City' => $this->city,
            'Province' => $this->province,
            'Birthdate' => $this->dob,
            'Gender' => $this->gender,
            'Position' => $this->position,
            'Status' => 'Active',
            'Username' => $this->email,
            'email' => $this->email,
            'password' => bcrypt("password"),
            'DateCreated' => now()->format('Y-m-d'),
            'TimeCreated' => now()->format('H:i:s'),
        ]);

        session()->flash('message', 'User created successfully!');

        // $this->reset();
    }

    public function render()
    {
        return view('livewire.user.create-user');
    }
}
