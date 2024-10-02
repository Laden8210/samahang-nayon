<?php

use App\Http\Controllers\GuestAPIController;
use App\Http\Controllers\RoomAPIController;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;


Route::post('/rooms', [RoomAPIController::class, 'getRoom']);
Route::post('/rooms/image', [RoomAPIController::class, 'getImage']);


Route::post('user/createUser', [GuestAPIController::class, 'create']);
Route::post('guest/login', [GuestAPIController::class, 'login']);



Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('rooms/searchRoom', [RoomAPIController::class, 'searchRoom']);

    Route::post('create-reservation', [GuestAPIController::class, 'createReservation']);
    Route::get('user/users', [GuestAPIController::class, 'getAllUser']);
});

Route::post('amenities', [GuestAPIController::class, 'getAmenities']);

Route::post('message/sendGuestMessage', [MessageController::class, 'sendGuestMessage']);
Route::post('message/getGuestMessages', [MessageController::class, 'getGuestMessages']);
Route::post('message/retrieveUserMessage', [MessageController::class, 'retrieveUserMessage']);

Route::post('reservation/getReservation', [GuestAPIController::class, 'getReservation']);

Route::post('reservation/cancelReservation', [GuestAPIController::class, 'cancelReservation']);

Route::post('reservation/getReservationDetails', [GuestAPIController::class, 'getReservationDetails']);


Route::post('user/getCurrentUser', [GuestAPIController::class, 'getCurrentUser']);


Route::post('requestOtp', [GuestAPIController::class, 'requestOtp']);
Route::post('changePassword', [GuestAPIController::class, 'changePassword']);
