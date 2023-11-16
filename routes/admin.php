<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PersonaController;
/* use App\Http\Controllers\Admin\NaveController; */
use App\Http\Controllers\Admin\RangoController;
use App\Http\Controllers\Admin\ShipController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Auth::routes();

Route::get('', [HomeController::class, 'index']);
Route::resource('users', UserController::class)->names('admin.users');
Route::resource('rangos', RangoController::class)->names('admin.rangos');
Route::resource('ships', ShipController::class)->names('admin.ships');
Route::resource('personas', PersonaController::class)->names('admin.personas');