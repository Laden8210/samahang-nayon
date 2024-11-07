<?php

namespace App\Livewire;

use App\Models\Amenities;
use Livewire\Component;
use App\Models\Reservation;
use Xendit\Refund\Refund;
use App\Models\Payment;
use Carbon\Carbon;
use App\Models\Guest;
use Illuminate\Support\Facades\Http;

class ViewBookingDetails extends Component
{
    public $ReservationId;
    public $reservation;
    public $Amenities;
    public $amenity_id;
    public $quantity;

    public $payment;

    public $subguestsFirstname;
    public $subguestsMiddlename;
    public $subguestsLastname;
    public $subguestsDob;
    public $subguestsGender;

    public $subguestsContactnumber;


    public function render()
    {
        return view('livewire.view-booking-details');
    }
    public function mount($ReservationId)
    {
        $this->ReservationId = $ReservationId;
        $this->reservation = Reservation::find($ReservationId);
        $this->Amenities = Amenities::all();
        $remainingBalance = $this->reservation->TotalCost;

        foreach ($this->reservation->reservationAmenities as $amenity) {
            $remainingBalance += $amenity->TotalCost;
        }
        foreach ($this->reservation->payments as $payment) {
            if ($payment->Status == 'Confirmed') {
                $remainingBalance -= $payment->AmountPaid;
            }
        }

        $this->payment = $remainingBalance;

        $penaltyRatePerHour = 100;


        $checkoutTime = Carbon::parse($this->reservation->DateCheckOut)->setTime(14, 0);

        if ($this->reservation->Status == 'Checked In') {
            if (now()->greaterThan($checkoutTime)) {
                $hoursLate = $checkoutTime->diffInHours(now());
                $this->reservation->TotalCost += $hoursLate * $penaltyRatePerHour;
            }
        }
    }


    public function addSubGuest()
    {

        $this->validate([
            'subguestsFirstname' => 'required',
            'subguestsMiddlename' => 'required',
            'subguestsLastname' => 'required',
            'subguestsDob' => 'required',
            'subguestsGender' => 'required',

            'subguestsContactnumber' => 'required',
        ]);

        $this->reservation->subguests()->create([
            'FirstName' => $this->subguestsFirstname,
            'MiddleName' => $this->subguestsMiddlename,
            'LastName' => $this->subguestsLastname,
            'Birthdate' => $this->subguestsDob,
            'Gender' => $this->subguestsGender,

            'ContactNumber' => $this->subguestsContactnumber,
        ]);

        session()->flash('subguest-message', 'Subguest added successfully.');
        $this->reset(['subguestsFirstname', 'subguestsMiddlename', 'subguestsLastname', 'subguestsDob', 'subguestsGender',  'subguestsContactnumber']);
    }
    public function addPayment()
    {
        $this->validate([
            'payment' => 'required|numeric|min:1',
        ]);

        $remainingBalance = $this->reservation->TotalCost;

        foreach ($this->reservation->reservationAmenities as $amenity) {
            $remainingBalance += $amenity->TotalCost;
        }

        foreach ($this->reservation->payments as $payment) {
            $remainingBalance -= $payment->AmountPaid;
        }

        if ($this->payment >= $remainingBalance) {
            session()->flash('message', 'Payment Exceeds Remaining Balance');
            $this->payment = '';
            return;
        }

        $this->reservation->payments()->create([
            'GuestId' => $this->reservation->GuestId,
            'AmountPaid' => $this->payment,
            'DateCreated' => date('Y-m-d'),
            'TimeCreated' => date('H:i:s'),
            'Status' => 'Confirmed',
            'PaymentType' => 'Cash',
            'ReferenceNumber' => $this->generateReferenceNumber(),
            'Purpose' => "Room Reservation",
        ]);

        session()->flash('message', 'Payment Complete');
    }


    public function confirmPayment($ref)
    {
        $payment = Payment::find($ref);
        $payment->Status = 'Confirmed';
        $guest = Guest::find($payment->GuestId);

        $message = "Dear {$guest->FirstName},\n\n" .
            "Your payment has been confirmed successfully!\n" .
            "Payment Reference: {$ref}\n" .
            "Amount Paid: {$payment->AmountPaid}\n" .
            "Payment Type: {$payment->PaymentType}\n" .
            "Date: " . now()->toDateString() . "\n" .
            "Status: Confirmed\n\n" .
            "Thank you for your payment! We look forward to serving you.";

        // Send SMS notification
        $response = Http::post('https://nasa-ph.com/api/send-sms', [
            'phone_number' => $guest->ContactNumber,
            'message' => $message
        ]);


        $payment->save();
        session()->flash('message', 'Payment Confirm');
    }





    public function addAmenities()
    {


        $this->validate([
            'amenity_id' => 'required|exists:amenities,AmenitiesId',
            'quantity' => 'required|integer|min:1',
        ]);

        $totalCost = Amenities::find($this->amenity_id)->Price * $this->quantity;

        $this->reservation->reservationAmenities()->create([
            'AmenitiesId' => $this->amenity_id,
            'Quantity' => $this->quantity,
            'TotalCost' => $totalCost,
        ]);

        session()->flash('message', 'Amenity Added');

        // Optionally reset the fields after submission
        $this->reset(['amenity_id', 'quantity']);
    }

    public function checkIn()
    {

        if ($this->reservation->DateCheckIn > now()) {
            session()->flash('message', 'Guest Cannot be Checked In Yet');
            return;
        }

        if ($this->reservation->DateCheckOut < now()) {
            session()->flash('message', 'Guest Cannot be Checked In Anymore');
            return;
        }

        if ($this->reservation->Status == 'Checked Out') {
            session()->flash('message', 'Guest Already Checked Out');
            return;
        }

        if ($this->reservation->Status == 'Checked In') {
            session()->flash('message', 'Guest Already Checked In');
            return;
        }


        $this->reservation->Status = 'Checked In';
        $this->reservation->save();
        $this->reservation->checkInOuts()->create([
            'GuestId' => $this->reservation->GuestId,
            'DateCreated' => now(),
            'TimeCreated' => now(),
            'Type' => 'Checked In'
        ]);
        session()->flash('message', 'Guest Checked In');
    }

    public function checkOut()
    {

        $this->reservation->Status = 'Checked Out';
        $this->reservation->save();
        $this->reservation->checkInOuts()->create([
            'GuestId' => $this->reservation->GuestId,
            'DateCreated' => now(),
            'TimeCreated' => now(),
            'Type' => 'Checked Out'
        ]);

        session()->flash('message', 'Guest Checked Out');
    }


    public function generateReferenceNumber()
    {
        return 'REF-' . date('YmdHis');
    }

    public function removeAmenity($id)
    {
        $amenity = $this->reservation->reservationAmenities->find($id);
        $amenity->delete();
        session()->flash('message', 'Amenity Removed');
    }
}
