<?php

use App\Http\Controllers\API\GuestAPIController;
use App\Http\Controllers\API\RoomAPIController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/rooms', [RoomAPIController::class, 'getRoom']);
Route::post('/rooms/image', [RoomAPIController::class, 'getImage']);


Route::get('user/users', [GuestAPIController::class, 'getAllUser']);
Route::post('user/createUser', [GuestAPIController::class, 'create']);
