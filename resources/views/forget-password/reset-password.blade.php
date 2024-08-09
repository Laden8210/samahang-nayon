@extends('layouts.main')

@section('title', 'Forget Password')
@section('content')

    <div class="flex justify-center items-center min-h-screen w-full">
        <div class="p-5 bg-slate-50 rounded shadow" style="width: 450px">
            <div class="flex justify-center">
                <img src="{{ asset('img/logo.jpg') }}" class="h-52 max-w-none py-5 rounded-full">
            </div>

            <h1 class="text-center text-2xl font-bold">Reset Password</h1>
            <p class="text-gray-400 text-sm text-center mb-10">Please kindly set your new password</p>

            <x-text-field1 name="password" placeholder="Enter new Password" model="email" label="New Password" />

            <div class="grid grid-cols-4  my-2">
                <div class="bg-cyan-500 h-2 rounded mx-1"></div>
                <div class="bg-cyan-500 h-2 rounded mx-1"></div>
                <div class="bg-cyan-500 h-2 rounded mx-1"></div>
                <div class="bg-cyan-500 h-2 rounded mx-1"></div>
            </div>

            <p>Password strength: <span class="font-bold">Excellent</span></p>

            @error('rate')
                <p class="text-red-500 text-xs italic mt-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
            @enderror

            <x-text-field1 name="password" placeholder="Re-enter password" model="email" label="Re-enter password" />
            @error('rate')
                <p class="text-red-500 text-xs italic mt-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
            @enderror

            <button class="w-full bg-cyan-500 text-white font-bold py-2 px-4 rounded mt-5">Confirm Password</button>
        </div>
    </div>

@endsection
