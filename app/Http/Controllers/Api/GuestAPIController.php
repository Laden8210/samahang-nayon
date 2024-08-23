<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use Illuminate\Http\Request;

class GuestAPIController extends Controller
{

    public function create(Request $request)
    {

        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'gender' => 'required|string|max:255',
            'contactnumber' => 'required|string|max:12',
            'emailaddress' => 'required|email|max:255',
            'password' => 'required|string|max:255',
        ]);




            $guest = Guest::create([
                'FirstName' => $validatedData['firstname'],
                'LastName' => $validatedData['lastname'],
                'MiddleName' => $validatedData['middlename'],
                'Street' => $validatedData['street'],
                'City' => $validatedData['city'],
                'Province' => $validatedData['province'],
                'Birthdate' => $validatedData['birthdate'],
                'Gender' => $validatedData['gender'],
                'ContactNumber' => $validatedData['contactnumber'],
                'EmailAddress' => $validatedData['emailaddress'],
                'password' => $validatedData['password'],
                'DateCreated' => now()->toDateString(),
                'TimeCreated' => now()->toTimeString(),
            ]);

            return response()->json(['message' => 'Guest created successfully'], 201);
        }


    public function getAllUser()
    {
        $guest = Guest::all();
        return json_encode($guest);
    }
}
