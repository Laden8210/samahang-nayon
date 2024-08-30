@extends('layouts.app')

@section('title', 'Promotion ')
@section('content')

    <div class="grid grid-cols-5 gap-2 ">

        <div class="shadow-lg rounded-lg col-span-4">
            <h1 class="text-xl font-bold p-2">Available Room</h1>
            @livewire('booking.room-list')
        </div>


        <div class="p-2 shadow-lg rounded-lg">
            <h2 class="font-bold mb-2">Legend</h2>
            <h3 class="text-base font-semibold">Room Type</h3>
            <hr>
            <div class="grid grid-flow-row gap-3 mt-2">

                <div class="flex justify-normal gap-2 items-center">
                    <div class="rounded-full bg-sky-500 w-3 h-3"></div>
                    <div class="text-sm">Single Bed</div>
                </div>

                <div class="flex justify-normal gap-2  items-center">
                    <div class="rounded-full bg-violet-500 w-3 h-3"></div>
                    <div class="text-sm">Double Bed</div>
                </div>

                <div class="flex justify-normal gap-2 items-center">
                    <div class="rounded-full bg-blue-800 w-3 h-3"></div>
                    <div class="text-sm">Matrimonial Bed</div>
                </div>

                <div class="flex justify-normal gap-2 items-center">
                    <div class="rounded-full bg-blue-500 w-3 h-3"></div>
                    <div class="text-sm">2 Double Bed</div>
                </div>

                <div class="flex justify-normal gap-2 items-center">
                    <div class="rounded-full bg-orange-500 w-3 h-3"></div>
                    <div class="text-sm">Family Room</div>
                </div>

                <div class="flex justify-normal gap-2 items-center">
                    <div class="rounded-full bg-green-800 w-3 h-3"></div>
                    <div class="text-sm">Fan Room</div>
                </div>

                <div class="flex justify-normal gap-2 items-center">
                    <div class="rounded-full bg-blue-500 w-3 h-3"></div>
                    <div class="text-sm">Single Bed</div>
                </div>
            </div>
            <hr class="my-2">
            <h3 class="text-base font-semibold">Room Status</h3>
            <hr>
            <div class="grid grid-flow-row gap-3 mt-2">
                <div class="flex justify-normal gap-2 items-center">
                    <div class="rounded-full border border-pink-500 w-3 h-3"></div>
                    <div class="text-sm">Reserve</div>
                </div>
                <div class="flex justify-normal gap-2 items-center">
                    <div class="rounded-full border border-red-500 w-3 h-3"></div>
                    <div class="text-sm">Occupied</div>
                </div>
                <div class="flex justify-normal gap-2 items-center">
                    <div class="rounded-full border border-slate-800 w-3 h-3"></div>
                    <div class="text-sm">Book</div>
                </div>
            </div>
        </div>

    </div>




@endsection
