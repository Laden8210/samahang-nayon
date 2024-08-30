<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{

    public function index()
    {
        return view('admin.booking.index');
    }


    public function create()
    {
        return view('admin.booking.booking-details');
    }


    public function bookingDetails(){
        return view('admin.booking.booking-details');
    }


}
