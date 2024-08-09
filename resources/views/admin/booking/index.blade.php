@extends('layouts.app')

@section('title', 'Booking')
@section('content')
    <h1 class="text-2xl font-bold p-2">Booking</h1>

    <h5 class="mx-2 font-bold">SEARCH</h5>

    <div class="justify-between flex p-1">

        <div class="relative mb-4 ">



            <input type="text"
                class="bg-gray-100 text-gray-900 placeholder-gray-400 px-3 py-2 pl-10 rounded-lg w-full outline-none focus:outline-none"
                placeholder="Search Booking . . . ">
                <span class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <i class="fas fa-search text-gray-400"></i>
                </span>
        </div>

        <div class="p-2">
            <a href="#" class="rounded bg-cyan-500 p-2 hover:bg-cyan-400 text-white">Create Booking</a>
        </div>


    </div>



    <div class="w-full flex p-2 bg-gray-50 rounded justify-center">
        <table class="w-full text-sm text-left rtl:text-right">
            <thead class="text-xs uppercase bg-gray-50  dark:text-gray-400">
                <tr>
                    <th >Booking Id</th>
                    <th>Full Name</th>
                    <th>Room</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="">
                <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>Room 1</td>
                    <td>2021-10-01</td>
                    <td>2021-10-03</td>
                    <td>Confirmed</td>
                    <td>
                        <button class=" p-2 rounded text-cyan-500">View</button>
                        <button class="text-cyan-500 p-2  rounded">Update</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

@endsection
