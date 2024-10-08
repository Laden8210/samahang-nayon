<?php

namespace App\Livewire\User;

use App\Models\Employee;
use App\Models\UserAccount;
use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Rules\Age;

class UpdateUser extends Component
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

    public $userId;


    public function render()
    {
        return view('livewire.user.update-user');
    }

    public function mount($userId)
    {
        $user = Employee::where('EmployeeId', $userId)->firstOrFail();
        $this->firstname = $user->FirstName;
        $this->middlename = $user->MiddleName;
        $this->lastname = $user->LastName;
        $this->contactNumber = $user->ContactNumber;
        $this->email = htmlentities($user->email, ENT_QUOTES, 'UTF-8');

        $this->street = $user->Street;
        $this->city = $user->City;
        $this->province = $user->Province;
        $this->dob = $user->Birthdate;
        $this->gender = $user->Gender;
        $this->position = $user->Position;
        $this->userId = $userId;
        $this->brgy = $user->Brgy;
    }

    public function updateUser()
    {
        $this->validate(
            [
                'firstname' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[\p{L} .-]+$/u'
                ],
                'middlename' => [
                    'nullable',
                    'string',
                    'max:255',
                    'regex:/^[\p{L} .-]+$/u'
                ],
                'lastname' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[\p{L} .-]+$/u'
                ],
                'contactNumber' => [
                    'required',
                    'string',
                    'max:12',
                    'regex:/^(?:\+63|0)9\d{9}$/'
                ],
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
        $user = Employee::where('EmployeeId', $this->userId)->firstOrFail();

        $user->update([
            'FirstName' => $this->firstname,
            'MiddleName' => $this->middlename,
            'LastName' => $this->lastname,
            'ContactNumber' => $this->contactNumber,
            'email' => $this->email,
            'Street' => $this->street,
            'City' => $this->city,
            'Province' => $this->province,
            'Birthdate' => $this->dob,
            'Gender' => $this->gender,
            'Position' => $this->position,
        ]);

        session()->flash('message', 'User updated successfully!');

        $this->reset();
    }
}
