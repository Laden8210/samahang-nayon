<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('', [LoginController::class, 'index']);
