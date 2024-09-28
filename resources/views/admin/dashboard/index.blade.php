@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-bold p-2">Dashboard</h1>

    <div class="bg-white p-4 rounded">
        <h2 class="font-bold">Overview</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-2">
            <x-dashboard-card title="Available Room" count="{{ $availableRooms }}" />
            <x-dashboard-card title="Occupied Room" count="{{ $occupiedRooms }}" />
            <x-dashboard-card title="Today's Check In" count="0" /> <!-- Update if necessary -->
            <x-dashboard-card title="Today's Check Out" count="100" /> <!-- Update if necessary -->
            <x-dashboard-card title="Today's Booking" count="{{ $totalBooking }}" />
            <x-dashboard-card title="Today's Reservation" count="{{ $totalReservation }}" />
            <x-dashboard-card title="Number of Users" count="{{$user}}" /> <!-- Update if necessary -->
        </div>
    </div>

@endsection
