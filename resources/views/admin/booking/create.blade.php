@extends('layouts.app')

@section('title', 'Booking')
@section('content')
    <div class="px-2">
        <h1 class="font-bold text-xl">Available Room</h1>
        <h2>Legend</h2>
        <div class="grid grid-cols-7 gap-1 text-xs">
            <p>Single Bed <span class="px-2 ms-2 rounded-full bg-cyan-500"></span></p>
            <p>Double Bed <span class="px-2 ms-2  rounded-full bg-violet-500"></span></p>
            <p>Matrimonial Bed <span class="px-2 ms-2 rounded-full bg-blue-500"></span></p>
            <p>2 Double Bed <span class="px-2 ms-2 rounded-full bg-orange-500"></span></p>
            <p>Family Bed <span class="px-2 ms-2 rounded-full bg-green-500"></span></p>
            <p>Fan Room<span class="px-2 ms-2 rounded-full bg-green-900"></span></p>
            <p>Occupied Bed <span class="px-2 ms-2 rounded-full border-2 border-red-800"></span></p>
            <p>Book Bed <span class="px-2 ms-2 rounded-full border-2 border-violet-800"></span></p>
            <p>Reserve  <span class="px-2 ms-2 rounded-full border-2 border-slate-900"></span></p>
        </div>
        <div class="bg-slate-50 p-5 rounded">
            <div class="grid grid-cols-12 gap-2">

                @for ($i = 0; $i < 35; $i++)
                    <div class="relative group">
                        <a href="{{ route('booking-details') }}"
                           class="h-20 bg-cyan-200 items-center flex justify-center border-2 border-red-600 rounded shadow translate hover:scale-105 duration-100 hover:shadow-xl">
                            {{$i}}
                        </a>

                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block">
                            <div class="bg-gray-800 text-white text-xs rounded py-1 px-2">
                                Booking details for item {{$i}}
                            </div>
                            <div class="w-2 h-2 bg-gray-800 transform rotate-45 mx-auto mt-1"></div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>


    </div>

@endsection
