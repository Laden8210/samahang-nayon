<?php

use App\Http\Controllers\API\GuestAPIController;
use App\Http\Controllers\API\RoomAPIController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

