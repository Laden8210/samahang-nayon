@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
    <h1 class="text-2xl font-bold p-2">Dashboard</h1>
    <div class=" bg-white p-4 rounded">
        <h2 class="font-bold ">Overview</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-2">
            <x-dashboard-card title="Total Users" count="100" />
            <x-dashboard-card title="Total Booking" count="100" />
            <x-dashboard-card title="Total Transaction" count="100" />
            <x-dashboard-card title="Total Room" count="100" />

            <x-dashboard-card title="Total Users" count="100" />
            <x-dashboard-card title="Total Booking" count="100" />
            <x-dashboard-card title="Total Transaction" count="100" />
            <x-dashboard-card title="Total Room" count="100" />
        </div>
    </div>

    <div class="w-full h-80 bg-white mt-2">
        <h2 class="font-bold p-4">Occupancy Rate</h2>

    </div>
@endsection
