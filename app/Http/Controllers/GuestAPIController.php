<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Http;
use App\Models\Room;
use Carbon\Carbon;
use App\Models\Promotion;
use App\Models\Notification;
use Illuminate\Support\Facades\Request as FacadesRequest;
use App\Models\SystemLog;
use App\Models\SubGuest;

class GuestAPIController extends Controller
{
    private $apiKey;


    private function isPasswordValid($password)
    {
        // Check for minimum length
        if (strlen($password) < 8) {
            return false;
        }

        // Check for at least one uppercase letter
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }

        // Check for at least one lowercase letter
        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }

        // Check for at least one numeric digit
        if (!preg_match('/[0-9]/', $password)) {
            return false;
        }

        // Check for at least one special character
        if (!preg_match('/[\W_]/', $password)) {
            return false;
        }

        return true; // Password is valid
    }
    public function create(Request $request)
    {
        // Validate the incoming request data
        // $validatedData = $request->validate([
        //     'firstname' => 'required|string|max:255',
        //     'lastname' => 'required|string|max:255',
        //     'middlename' => 'nullable|string|max:255',
        //     'street' => 'required|string|max:255',
        //     'city' => 'required|string|max:255',
        //     'province' => 'required|string|max:255',
        //     'birthdate' => 'required|date',
        //     'gender' => 'required|string|max:255',
        //     'contactnumber' => 'required|string|max:12',
        //     'emailaddress' => 'required|email|max:255',
        //     'password' => 'required|string|max:32',
        // ]);

        if (empty($request->input('firstname'))) {
            return response()->json(['error' => 'First name is required.'], 200);
        } elseif (!is_string($request->input('firstname')) || strlen($request->input('firstname')) > 255) {
            return response()->json(['error' => 'First name must be a string and cannot exceed 255 characters.'], 200);
        }

        // Check lastname
        if (empty($request->input('lastname'))) {
            return response()->json(['error' => 'Last name is required.'], 200);
        } elseif (!is_string($request->input('lastname')) || strlen($request->input('lastname')) > 255) {
            return response()->json(['error' => 'Last name must be a string and cannot exceed 255 characters.'], 200);
        }

        // Check middlename (nullable)
        if ($request->input('middlename') !== null && !is_string($request->input('middlename'))) {
            return response()->json(['error' => 'Middle name must be a string and cannot exceed 255 characters.'], 200);
        } elseif (strlen($request->input('middlename')) > 255) {
            return response()->json(['error' => 'Middle name cannot exceed 255 characters.'], 200);
        }

        // Check street
        if (empty($request->input('street'))) {
            return response()->json(['error' => 'Street is required.'], 200);
        } elseif (!is_string($request->input('street')) || strlen($request->input('street')) > 255) {
            return response()->json(['error' => 'Street must be a string and cannot exceed 255 characters.'], 200);
        }

        // Check city
        if (empty($request->input('city'))) {
            return response()->json(['error' => 'City is required.'], 200);
        } elseif (!is_string($request->input('city')) || strlen($request->input('city')) > 255) {
            return response()->json(['error' => 'City must be a string and cannot exceed 255 characters.'], 200);
        }

        // Check province
        if (empty($request->input('province'))) {
            return response()->json(['error' => 'Province is required.'], 200);
        } elseif (!is_string($request->input('province')) || strlen($request->input('province')) > 255) {
            return response()->json(['error' => 'Province must be a string and cannot exceed 255 characters.'], 200);
        }

        // Check birthdate
        if (empty($request->input('birthdate'))) {
            return response()->json(['error' => 'Birthdate is required.'], 200);
        } elseif (!strtotime($request->input('birthdate'))) {
            return response()->json(['error' => 'Birthdate must be a valid date.'], 200);
        }

        // Check gender
        if (empty($request->input('gender'))) {
            return response()->json(['error' => 'Gender is required.'], 200);
        } elseif (!is_string($request->input('gender')) || strlen($request->input('gender')) > 255) {
            return response()->json(['error' => 'Gender must be a string and cannot exceed 255 characters.'], 200);
        }

        // Check contactnumber
        if (empty($request->input('contactnumber'))) {
            return response()->json(['error' => 'Contact number is required.'], 200);
        } elseif (!is_string($request->input('contactnumber')) || strlen($request->input('contactnumber')) > 12) {
            return response()->json(['error' => 'Contact number must be a string and cannot exceed 12 characters.'], 200);
        }

        // Check emailaddress
        if (empty($request->input('emailaddress'))) {
            return response()->json(['error' => 'Email address is required.'], 200);
        } elseif (!filter_var($request->input('emailaddress'), FILTER_VALIDATE_EMAIL) || strlen($request->input('emailaddress')) > 255) {
            return response()->json(['error' => 'Email address must be a valid email.'], 200);
        }

        // Check password
        if (empty($request->input('password'))) {
            return response()->json(['error' => 'Password is required.'], 200);
        } elseif (!is_string($request->input('password')) || strlen($request->input('password')) > 32) {
            return response()->json(['error' => 'Password must be a string and cannot exceed 32 characters.'], 200);
        }

        $validatedData = $request->only([
            'firstname',
            'lastname',
            'middlename',
            'street',
            'city',
            'province',
            'birthdate',
            'gender',
            'contactnumber',
            'emailaddress',
            'password'
        ]);



        $existingGuest = Guest::where('EmailAddress', $validatedData['emailaddress'])->first();

        if ($existingGuest) {
            return response()->json(['error' => 'Email address already exists'], 200);
        }

        if (Guest::where('ContactNumber', $validatedData['contactnumber'])->first()) {
            return response()->json(['error' => 'Contact number already exists'], 200);
        }


        // TODO: validate format contact number

        $contactNumber = $request->input('contactnumber');
        if (!preg_match('/^(09\d{9}|\+639\d{9})$/', $contactNumber)) {
            return response()->json(['error' => 'Invalid Philippine contact number format'], 400);
        }



        $password = $validatedData['password'];



        if (!$this->isPasswordValid($password)) {
            return response()->json(['error' => 'Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.']);
        }

        // TODO: validate age, 18 above


        $birthdate = Carbon::parse($validatedData['birthdate']);
        $now = Carbon::now();

        if ($birthdate->diffInYears($now) < 18) {
            return response()->json(['error' => 'Guest must be at least 18 years old']);
        }


        // TODO: capitalize first letter of each word
        $validatedData['firstname'] = ucwords(strtolower($validatedData['firstname']));
        $validatedData['lastname'] = ucwords(strtolower($validatedData['lastname']));
        $validatedData['middlename'] = ucwords(strtolower($validatedData['middlename']));
        $guest = Guest::create([
            'FirstName' => $validatedData['firstname'],
            'LastName' => $validatedData['lastname'],
            'MiddleName' => $validatedData['middlename'] ?? null,
            'Street' => $validatedData['street'],
            'City' => $validatedData['city'],
            'Province' => $validatedData['province'],
            'Birthdate' => $validatedData['birthdate'],
            'Gender' => $validatedData['gender'],
            'ContactNumber' => $validatedData['contactnumber'],
            'Brgy' => $request->brgy ?? "",
            'EmailAddress' => $validatedData['emailaddress'],
            'password' => bcrypt($validatedData['password']),
            'DateCreated' => now()->toDateString(),
            'TimeCreated' => now()->toTimeString(),
        ]);

        SystemLog::create([
            'log' => 'New guest created from IP: ' . FacadesRequest::ip() .
                ' for email: ' . $validatedData['emailaddress'] .
                ' on ' . now()->toDateTimeString(),
            'action' => 'Create Guest',
            'date_created' => now()->toDateString(),
        ]);



        return response()->json(
            [
                'message' => 'Guest created successfully',
                'guest' => $guest,
                'token' => $guest->createToken('Samahang-Nayon')->plainTextToken
            ],
            201
        );
    }

    public function getCurrentUser(Request $request)
    {
        $guest = Auth::guard('api')->user();
        if ($guest) {
            return response()->json($guest);
        }

        return response()->json(['error' => 'Unauthorized'], 200);
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'emailaddress' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        $guest = Guest::where('EmailAddress', $validatedData['emailaddress'])->first();

        if (!$guest) {
            return response()->json(['error' => 'Guest not found'], 200);
        }

        if (!Hash::check($validatedData['password'], $guest->Password)) {
            SystemLog::create([
                'log' => 'Guest login failed from IP: ' . FacadesRequest::ip() .
                    ' for email: ' . $validatedData['emailaddress'] .
                    ' on ' . now()->toDateTimeString(),
                'action' => 'Guest Login',
                'date_created' => now()->toDateString(),
            ]);
            return response()->json(['error' => 'Invalid password'], 200);
        }



        $token = $guest->createToken('Samahang-Nayon')->plainTextToken;

        return response()->json(['token' => $token, 'message' => 'Successfully Login'], 200);
    }


    public function getAllUser()
    {
        $guest = Auth::guard('api')->user();
        if ($guest) {
            return response()->json($guest);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function createReservation(Request $request)
    {

        $validatedData = $request->validate([
            'room_id' => 'required|integer',
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            'amenities' => 'nullable|array',
            'amenities.*.id' => 'required_with:amenities|integer',
            'amenities.*.name' => 'required_with:amenities|string',
            'amenities.*.price' => 'required_with:amenities|numeric',
            'amenities.*.quantity' => 'required_with:amenities|integer',
            'sub_guests' => 'nullable|array',
            'payment_option' => 'required|string|in:full,partial',
            'total_adult' => 'required|integer',
            'total_children' => 'required|integer',
            'discountType' => 'nullable|string',
            'id_number' => 'nullable|string'
        ]);



        $guest = Auth::guard('api')->user();
        if (!$guest) {
            return response()->json(['error' => 'Invalid Session'], 200);
        }

        // TODO: validate if room is available

        if (Reservation::where('RoomId', $validatedData['room_id'])
            ->where('DateCheckIn', '<=', $validatedData['check_out'])
            ->where('DateCheckOut', '>=', $validatedData['check_in'])
            ->where('Status', '!=', 'Cancelled')
            ->exists()) {
            return response()->json(['error' => 'Room is not available'], 200);
        }

        $room = Room::find($validatedData['room_id']);

        $checkIn = Carbon::parse($validatedData['check_in']);
        $checkOut = Carbon::parse($validatedData['check_out']);
        $lengthOfStay = $checkIn->diffInDays($checkOut);

        $totalCost = $room->RoomPrice * $lengthOfStay;


        if ($validatedData['discountType'] == 'Senior Citizen' || $validatedData['discountType'] == 'PWD') {
            $totalCost = $totalCost - ($totalCost * 0.10);
        } else {
            $promotion = Promotion::where('StartDate', '<=', $checkOut)
                ->where('EndDate', '>=', $checkIn)
                ->whereHas('discountedRooms', function ($query) use ($room) {
                    $query->where('RoomId', $room->RoomId);
                })
                ->first();

            if ($promotion) {
                $totalCost = $totalCost - ($totalCost * ($promotion->Discount / 100));
            }
        }




        $reservation = Reservation::create([
            'GuestId' => $guest->GuestId,
            'RoomId' => $validatedData['room_id'],
            'DateCheckIn' => $validatedData['check_in'],
            'DateCheckOut' => $validatedData['check_out'],
            'Status' => $validatedData['payment_option'] == 'partial' ? 'Reserved' : 'Booked',
            'TotalCost' => $totalCost,
            'DateCreated' => now()->toDateString(),
            'TimeCreated' => now()->toTimeString(),
            'TotalAdult' => $validatedData['total_adult'],
            'TotalChildren' => $validatedData['total_children'],
            'OriginalCost' => $room->RoomPrice * $lengthOfStay,
            'Discount' => $validatedData['discountType'] != 'None' ? 10 : ($promotion->Discount ?? 0),
            'Source' => 'Online',
            'DiscountType' => $validatedData['discountType'] ?? null,
            'IdNumber' => $validatedData['id_number'] ?? null
        ]);




        $totalPayment = 0;

        $totalAmenityCost = 0;
        foreach ($validatedData['amenities'] as $amenity) {

            $sum = $amenity['price'] * $amenity['quantity'];


            $reservation->reservationAmenities()->create([
                'AmenitiesId' => $amenity['id'],
                'Quantity' => $amenity['quantity'],
                'TotalCost' => $sum,
            ]);
            $totalPayment += $sum;
            $totalAmenityCost += $sum;
        }

        foreach ($validatedData['sub_guests'] as $sub_guest) {
            $reservation->subGuests()->create([
                'FirstName' => $sub_guest['first_name'],
                'LastName' => $sub_guest['last_name'],
                'MiddleName' => $sub_guest['middle_name'], // Corrected key
                'ContactNumber' => $sub_guest['contact_number'], // Corrected key
                'EmailAddress' => $sub_guest['email'], // Corrected key
                'Birthdate' => $sub_guest['birthdate'], // Corrected key
                'Gender' => $sub_guest['gender']
            ]);
        }


        if($validatedData['discountType'] == 'Senior Citizen' || $validatedData['discountType'] == 'PWD'){
            $partialPaymentAmount = (($room->RoomPrice * $lengthOfStay) - ( ($room->RoomPrice * $lengthOfStay) * 0.1)) * 0.30;
        }else{
            $promotion = Promotion::where('StartDate', '<=', $checkOut)
                ->where('EndDate', '>=', $checkIn)
                ->whereHas('discountedRooms', function ($query) use ($room) {
                    $query->where('RoomId', $room->RoomId);
                })
                ->first();

            if ($promotion) {
                $partialPaymentAmount = (($room->RoomPrice * $lengthOfStay) - ( ($room->RoomPrice * $lengthOfStay) * ($promotion->Discount / 100))) * 0.30;
            }else{
                $partialPaymentAmount = (($room->RoomPrice * $lengthOfStay) * 0.30);
            }
        }




        if ($validatedData['payment_option'] == 'partial') {
            $reservation->payments()->create([
                'GuestId' => $guest->GuestId,
                'AmountPaid' => $partialPaymentAmount ?? 0,
                'DateCreated' => date('Y-m-d'),
                'TimeCreated' => date('H:i:s'),
                'Status' => 'Confirmed',
                'PaymentType' => 'Gcash',
                'ReferenceNumber' => $this->generateReferenceNumber(),
                'Purpose' => "Room Reservation",
            ]);




            $this->apiKey = 'c2tfdGVzdF80OE1nWVk3U0dLdDY5dkVQZnRnZGpmS286';
            $data = [
                'data' => [
                    'attributes' => [
                        'billing' => [
                            'name' => $guest->FirstName . ' ' . $guest->LastName,
                            'email' => $guest->EmailAddress,
                            'phone' => $guest->ContactNumber
                        ],
                        'send_email_receipt' => true,
                        'show_description' => true,
                        'show_line_items' => true,
                        'description' => 'Room Reservation Partial Payment',
                        'line_items' => [
                            [
                                'currency' => 'PHP',
                                'amount' => (int)($partialPaymentAmount * 100),

                                'description' => 'Room Reservation Partial Payment',
                                'name' => $reservation->Room->RoomType,
                                'quantity' => 1
                            ],

                        ],
                        'payment_method_types' => ['gcash'],
                        'reference_number' => $reservation->payments->first()->ReferenceNumber,
                    ]
                ]
            ];

            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Basic ' . $this->apiKey,
                ])->post('https://api.paymongo.com/v1/checkout_sessions', $data);



                if ($response->successful()) {
                    return response()->json($response->json());
                } else {

                    return response()->json([
                        'error' => $response->body(),
                        'status' => $response->status()
                    ], $response->status());
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage()
                ], 500);
            }
        } else {

            $reservation->payments()->create([
                'GuestId' => $guest->GuestId,
                'AmountPaid' => $totalCost + $totalPayment ?? 0,
                'DateCreated' => date('Y-m-d'),
                'TimeCreated' => date('H:i:s'),
                'Status' => 'Confirmed',
                'PaymentType' => 'Gcash',
                'ReferenceNumber' => $this->generateReferenceNumber(),
                'Purpose' => "Room Reservation",
            ]);

            $this->apiKey = 'c2tfdGVzdF80OE1nWVk3U0dLdDY5dkVQZnRnZGpmS286';
            $data = [
                'data' => [
                    'attributes' => [
                        'billing' => [
                            'name' => $guest->FirstName . ' ' . $guest->LastName,
                            'email' => $guest->EmailAddress,
                            'phone' => $guest->ContactNumber
                        ],
                        'send_email_receipt' => true,
                        'show_description' => true,
                        'show_line_items' => true,
                        'description' => 'Room Reservation',
                        'line_items' => [
                            [
                                'currency' => 'PHP',
                                'amount' => (int)($reservation->room->RoomPrice * 100) -
                                    (($reservation->room->RoomPrice * 100) * (($promotion->Discount ?? 0) / 100)),

                                'description' => 'Room Reservation',
                                'name' => $reservation->Room->RoomType,
                                'quantity' => $lengthOfStay
                            ],
                            ...$reservation->reservationAmenities->map(function ($amenity) {
                                return [
                                    'currency' => 'PHP',
                                    'amount' => (int)($amenity->amenity->Price * 100),
                                    'description' => 'Amenity',
                                    'name' => $amenity->amenity->Name,
                                    'quantity' => $amenity->Quantity
                                ];
                            })
                        ],
                        'payment_method_types' => ['gcash'],
                        'reference_number' => $reservation->payments->first()->ReferenceNumber,
                    ]
                ]
            ];

            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Basic ' . $this->apiKey,
                ])->post('https://api.paymongo.com/v1/checkout_sessions', $data);



                if ($response->successful()) {

                    $notification = new Notification();
                    $notification->isForGuest = false;
                    $notification->Title = 'New Reservation';
                    $notification->Type = 'Reservation';
                    $notification->Message = 'A new reservation has been created for ' . $guest->FirstName . ' ' . $guest->LastName . '. Please confirm and proceed with the necessary actions.';
                    $notification->save();


                    SystemLog::create([
                        'log' => 'Reservation created successfully from IP: ' . FacadesRequest::ip() .
                            ' for email: ' . $request->email .
                            ' on ' . date('Y-m-d H:i:s'),
                        'action' => 'Create Reservation',
                        'date_created' => date('Y-m-d')
                    ]);



                    return response()->json($response->json());
                } else {

                    return response()->json([
                        'error' => $response->body(),
                        'status' => $response->status()
                    ], $response->status());
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage()
                ], 500);
            }
        }
    }

    public function getReservation(Request $request)
    {
        $guest = Auth::guard('api')->user();
        if (!$guest) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $status = $request->status;

        $reservations = Reservation::where('GuestId', $guest->GuestId)
            ->when($status, function ($query, $status) {
                if (in_array($status, ['Booked', 'Reserved'])) {
                    return $query->whereIn('Status', ['Booked', 'Reserved']);
                }
                return $query->where('Status', $status);
            })
            ->with(['room', 'reservationAmenities', 'payments'])
            ->get();

        return response()->json($reservations);
    }


    public function cancelReservation(Request $request)
    {
        $guest = Auth::guard('api')->user();
        if (!$guest) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $reservation = Reservation::find($request->reservation_id);

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        if ($reservation->Status == 'Cancelled') {
            return response()->json(['message' => 'Reservation already cancelled'], 200);
        }


        // only canceel if 3 days before check in

        $checkIn = Carbon::parse($reservation->DateCheckIn);

        if ($checkIn->diffInDays(now()) < 3) {
            return response()->json(['message' => 'Cannot cancel reservation 3 days before check in'], 200);
        }



        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $reservation->update([
            'Status' => 'Cancelled',
            'DateCancelled' => now()
        ]);

        $notification = new Notification();
        $notification->isForGuest = false;
        $notification->Title = 'Reservation Cancellation';
        $notification->Type = 'Cancellation';
        $notification->Message = 'The reservation for ' . $guest->FirstName . ' ' . $guest->LastName . ' has been canceled. The system has been updated automatically.';
        $notification->save();

        SystemLog::create([
            'log' => 'Reservation canceled successfully from IP: ' . FacadesRequest::ip() .
                ' for email: ' . $request->email .
                ' on ' . date('Y-m-d H:i:s'),
            'action' => 'Cancel Reservation',
            'date_created' => date('Y-m-d')
        ]);


        return response()->json(['message' => 'Reservation cancelled successfully'], 200);
    }

    public function getAmenities()
    {
        $amenities = Amenities::all();
        return response()->json($amenities);
    }


    public function generateReferenceNumber()
    {
        return 'REF-' . date('YmdHis');
    }

    public function getReservationDetails(Request $request)
    {
        $guest = Auth::guard('api')->user();

        // Check if the user is authenticated
        if (!$guest) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Validate the request data
        $request->validate([
            'reservation_id' => 'required|integer|exists:reservations,ReservationId', // Update to check for ReservationId
        ]);

        $reservation = Reservation::with(['payments', 'room', 'reservationAmenities.amenity', 'subGuests']) // Correct 'payment' to 'payments'
            ->where('ReservationId', $request->reservation_id) // Use where() instead of find()
            ->first();

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        return response()->json($reservation);
    }

    public function requestOtp(Request $request)
    {


        $validatedData = $request->validate([
            'contactnumber' => 'required|string|max:12',
        ]);

        $guest = Guest::where('ContactNumber', $validatedData['contactnumber'])->first();

        if (!$guest) {
            return response()->json(['message' => 'Guest not found'], 404);
        }

        $otp = rand(1000, 9999);


        $response = Http::post('https://nasa-ph.com/api/send-sms', [
            'phone_number' => $guest->ContactNumber,
            'message' => "Your OTP code is: $otp. Please use this code to reset your password.",
        ]);
        $token = $guest->createToken('Samahang-Nayon')->plainTextToken;

        return response()->json(['otp' => $otp, 'token' => $token, 'guest' => $guest], 200);
    }

    public function changePassword(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'password' => 'required|string',
        ]);

        // Get the authenticated guest
        $guest = Auth::guard('api')->user();
        if (!$guest) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $nGuest = Guest::find($guest->GuestId);

        $nGuest->Password = bcrypt($request->password);
        $nGuest->save();

        // Log the password change
        SystemLog::create([
            'log' => 'Password changed successfully from IP: ' . FacadesRequest::ip() .
                ' for email: ' . $guest->EmailAddress .
                ' on ' . date('Y-m-d H:i:s'),
            'action' => 'Change Password',
            'date_created' => date('Y-m-d')
        ]);

        return response()->json(['message' => $nGuest], 200);
    }

    public function addAmenities(Request $request)
    {



        $validatedData = $request->validate([
            'reservation_id' => 'required|integer',
            'amenities_id' => 'required|integer',
            'quantity' => 'required|integer',
            'total_cost' => 'required|numeric'
        ]);

        $reservation = Reservation::find($validatedData['reservation_id']);

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }


        $reservation->reservationAmenities()->create([
            'AmenitiesId' => $validatedData['amenities_id'],
            'Quantity' => $validatedData['quantity'],
            'TotalCost' => $validatedData['total_cost'],
        ]);
    }

    public function addSubGuest(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'birthdate' => 'required|date',
            'contact_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'gender' => 'required|string',
            'reservation_id' => 'required|integer'

        ]);

        try {

            $subGuest = SubGuest::create([
                'FirstName' => $validatedData['first_name'],
                'LastName' => $validatedData['last_name'],
                'MiddleName' => $validatedData['middle_name'],
                'Birthdate' => $validatedData['birthdate'],
                'ContactNumber' => $validatedData['contact_number'],
                'EmailAddress' => $validatedData['email'],
                'Gender' => $validatedData['gender'],
                'ReservationId' => $validatedData['reservation_id']
            ]);


            return response()->json([
                'message' => 'Sub-guest added successfully',
                'sub_guest' => $subGuest
            ], 201);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Failed to add sub-guest', 'error' => $e->getMessage()], 500);
        }
    }
}
