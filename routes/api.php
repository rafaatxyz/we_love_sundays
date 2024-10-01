<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SundayController;

Route::post('/v1/count-sundays', [SundayController::class, 'countSundays']);
