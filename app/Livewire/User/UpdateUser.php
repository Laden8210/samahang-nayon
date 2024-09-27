<?php

namespace App\Livewire\User;

use App\Models\Employee;
use App\Models\UserAccount;
use Livewire\Component;
use Illuminate\Validation\Rule;


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
    }

    public function updateUser()
    {
        $this->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'contactNumber' => 'required|string|max:15',
            'email' => ['required', 'email', Rule::unique('employees', 'email')->ignore($this->userId, 'EmployeeId')],
            'street' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => ['required', Rule::in(['Male', 'Female'])],
            'position' => ['required', Rule::in(['System Administrator', 'Manager', 'Receptionist'])],
        ]);

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
