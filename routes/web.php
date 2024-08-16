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


Route::get('admin/', [DashboardController::class, 'index']);


Route::get('admin/booking', [BookingController::class, 'index'])->name('booking');
Route::get('admin/booking/create', [BookingController::class, 'create'])->name('createBooking');
Route::get('admin/booking/booking-details', [BookingController::class, 'bookingDetails'])->name('booking-details');


Route::get('admin/rooms', [RoomController::class, 'index'])->name('rooms');
Route::get('admin/rooms/add', [RoomController::class, 'addRoom'])->name('addRoom');
Route::get('admin/rooms/update/{roomId}', [RoomController::class, 'updateRoom'])->name('updateRoom');

Route::get('admin/user', [UserController::class, 'index'])->name('user');
Route::get('admin/user/add', [UserController::class, 'addUser'])->name('addUser');
Route::get('admin/user/update/{userId}', [UserController::class, 'updateUser'])->name('updateUser');

Route::get('forget-password', [ForgetPasswordController::class, 'index'])->name('forget-password');
Route::get('reset-password', [ForgetPasswordController::class, 'resetPassword'])->name('reset-password');
Route::get('password-changed', [ForgetPasswordController::class, 'passwordChanged'])->name('password-changed');

Route::get(('admin/system-log'), [SystemLogController::class, 'index'])->name('system-log');

Route::get('admin/amenities', [AmenitiesController::class, 'index'])->name('amenities');
Route::get('admin/promotions', [PromotionController::class, 'index'])->name('promotions');
