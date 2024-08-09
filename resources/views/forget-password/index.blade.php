@extends('layouts.main')

@section('title', 'Forget Password')
@section('content')

    <div class="flex justify-center items-center min-h-screen">
        <div class="p-5 bg-slate-50 rounded shadow" style="width: 450px">
            <div class="flex justify-center">
                <img src="{{ asset('img/logo.jpg') }}" class="h-52 max-w-none py-5 rounded-full">
            </div>

            <h1 class="text-center text-2xl font-bold">Forget your password?</h1>
            <p class="text-gray-400 text-sm text-center mb-10">Enter your email address and we'll send you a link to reset your password</p>

            <x-text-field1 name="email" placeholder="Enter Email" model="email" label="Email" />
            @error('rate')
                <p class="text-red-500 text-xs italic mt-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
            @enderror

            <button class="w-full bg-cyan-500 text-white font-bold py-2 px-4 rounded mt-5">Send Reset Link</button>

            <div class="flex justify-center mt-5">
                <a href="" class=" font-medium text-sm"><i class="fas fa-chevron-left"></i> Back to login</a>
            </div>

        </div>
    </div>

@endsection
