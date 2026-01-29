<?php

use App\Http\Controllers\Web\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/order', [LandingController::class, 'createOrder']);



