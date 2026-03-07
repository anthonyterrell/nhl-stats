<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/{league?}', DashboardController::class)
    ->where('league', 'nhl|pwhl')
    ->name('dashboard');
