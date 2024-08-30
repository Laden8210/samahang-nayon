@extends('layouts.app')

@section('title', 'Booking')
@section('content')
    <div class="px-2">


        <div class="grid grid-cols-5 gap-5">


            <div class="bg-slate-50 p-5 rounded col-span-4 shadow-lg h-auto ">
                <h1 class="font-bold text-xl mb-2">Available Room</h1>
                @livewire('booking.room-list')
            </div>

            <div class="p-2 shadow rounded-lg">
                <h2 class="text-xl font-semibold">Legend</h2>
                <hr>
                <div class="text-xs grid grid-flow-row grid-rows-12 gap-2 py-2">
                    <p>Single Bed <span class="px-2 ms-2 rounded-full bg-cyan-500"></span></p>
                    <p>Double Bed <span class="px-2 ms-2  rounded-full bg-violet-500"></span></p>
                    <p>Matrimonial Bed <span class="px-2 ms-2 rounded-full bg-blue-500"></span></p>
                    <p>2 Double Bed <span class="px-2 ms-2 rounded-full bg-orange-500"></span></p>
                    <p>Family Bed <span class="px-2 ms-2 rounded-full bg-green-500"></span></p>
                    <p>Fan Room<span class="px-2 ms-2 rounded-full bg-green-900"></span></p>
                    <p>Occupied Bed <span class="px-2 ms-2 rounded-full border-2 border-red-800"></span></p>
                    <p>Book Bed <span class="px-2 ms-2 rounded-full border-2 border-violet-800"></span></p>
                    <p>Reserve <span class="px-2 ms-2 rounded-full border-2 border-slate-900"></span></p>
                </div>
            </div>
        </div>
    </div>

@endsection
