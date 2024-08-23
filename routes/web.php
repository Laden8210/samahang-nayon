<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForgetPasswordController;
use PHPUnit\Event\Telemetry\System;
use App\Http\Controllers\SystemLogController;
use App\Http\Controllers\AmenitiesController;
use App\Http\Controllers\PromotionController;


Route::get('', [LoginController::class, 'index']);
Route::get('login', [LoginController::class, 'index']);
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function () {

    Route::get('admin/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('admin/rooms', [RoomController::class, 'index'])->name('rooms');
    Route::get('admin/rooms/add', [RoomController::class, 'addRoom'])->name('addRoom');
    Route::get('admin/rooms/update/{roomId}', [RoomController::class, 'updateRoom'])->name('updateRoom');
    Route::get('admin/rooms/view/{roomId}', [RoomController::class, 'viewRoom'])->name('viewRoom');

    Route::get('admin/user', [UserController::class, 'index'])->name('user');

    Route::get('admin/user/update/{userId}', [UserController::class, 'updateUser'])->name('updateUser');
    Route::get(('admin/system-log'), [SystemLogController::class, 'index'])->name('system-log');
});
Route::get('admin/user/add', [UserController::class, 'addUser'])->name('addUser');









Route::get('forget-password', [ForgetPasswordController::class, 'index'])->name('forget-password');
Route::get('reset-password', [ForgetPasswordController::class, 'resetPassword'])->name('reset-password');
Route::get('password-changed', [ForgetPasswordController::class, 'passwordChanged'])->name('password-changed');



Route::get('receptionist/amenities', [AmenitiesController::class, 'index'])->name('amenities');
Route::get('receptionist/promotions', [PromotionController::class, 'index'])->name('promotions');
Route::get('receptionist/booking', [BookingController::class, 'index'])->name('booking');
Route::get('receptionist/booking/create', [BookingController::class, 'create'])->name('createBooking');
Route::get('receptionist/booking/booking-details', [BookingController::class, 'bookingDetails'])->name('booking-details');
