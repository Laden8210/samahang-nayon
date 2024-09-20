@extends('layouts.main')

@section('title', 'Forget Password')
@section('content')

<form action="{{ route('confirm-change-password') }}" method="POST">
    @csrf

    <div class="flex justify-center items-center min-h-screen w-full">
        <div class="p-5 bg-slate-50 rounded shadow" style="width: 450px">
            <div class="flex justify-center">
                <img src="{{ asset('img/logo.jpg') }}" class="h-52 max-w-none py-5 rounded-full">
            </div>

            <h1 class="text-center text-2xl font-bold">Reset Password</h1>
            <p class="text-gray-400 text-sm text-center mb-10">Please kindly set your new password</p>

            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Enter New Password</label>
            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-50"
                   type="password" name="password" id="password" placeholder="Enter New Password" value="{{ old('password') }}">
            @error('password')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror

            <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm Password</label>
            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-50"
                   type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" value="{{ old('confirm_password') }}">
            @error('confirm_password')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror

            @if (session('error'))
                <p class="text-red-500 text-xs italic mt-1"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</p>
            @endif

            <button class="w-full bg-cyan-500 text-white font-bold py-2 px-4 rounded mt-5">Confirm Password</button>
        </div>
    </div>

</form>
@endsection
