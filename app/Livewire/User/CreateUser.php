<?php

namespace App\Livewire\User;

use App\Models\Employee;
use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\UserAccount;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Rules\Age;
use Illuminate\Support\Facades\Http;
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

    public $apiProvince = [];
    public $apiCity = [];
    public $apiBrgy = [];
    public $selectedProvince = null;
    public $selectedCity = null;

    public $selectedBrgy = null;


    public function createUser()
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
                    'regex:/^(?:\+63|0)9\d{9}$/',
                    'unique:employees,ContactNumber', // Ensure unique contact number
                ],
                'email' => 'required|email|unique:employees,email',
                'street' => 'required|string|max:255',
                'selectedProvince' => 'required',
                'selectedCity' => 'required',
                'selectedBrgy' => 'required',
                'dob' => [
                    'required',
                    'date',
                    'before_or_equal:' . now()->subYears(18)->toDateString(), // Ensure at least 18 years old
                ],
                'gender' => ['required', Rule::in(['Male', 'Female'])],
                'position' => ['required', Rule::in(['System Administrator', 'Manager', 'Receptionist'])],
            ]
        );

            $birthdate = new \DateTime($this->dob);
            $month = $birthdate->format('m');
            $day = $birthdate->format('d');
            $year = $birthdate->format('Y');

            $defaultPassword = Str::lower($this->lastname) . $month . $day . $year;





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


        Employee::create([
            'FirstName' => $this->firstname,
            'MiddleName' => $this->middlename,
            'LastName' => $this->lastname,
            'ContactNumber' => $this->contactNumber,
            'email' => $this->email,
            'Street' => $this->street,
            'Brgy' => $brgy,
            'City' => $city,
            'Province' => $province,
            'Birthdate' => $this->dob,
            'Gender' => $this->gender,
            'Position' => $this->position,
            'Status' => 'Active',
            'Username' => $this->email,
            'email' => $this->email,
            'password' => bcrypt($defaultPassword),
            'DateCreated' => now()->format('Y-m-d'),
            'TimeCreated' => now()->format('H:i:s'),
        ]);

        $response = Http::post('https://nasa-ph.com/api/send-sms', [
            'phone_number' => $this->contactNumber,
            'message' => "Your account has been created. Your username is your email and your password is $defaultPassword. Please change your password after logging in.",
        ]);

        session()->flash('message', 'User created successfully!');

        // $this->reset();
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
        $this->fetchRegions();
        return view('livewire.user.create-user');
    }
}
