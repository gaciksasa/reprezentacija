<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TimoviController;
use App\Http\Controllers\IgraciController;
use App\Http\Controllers\UtakmiceController;
use App\Http\Controllers\StadioniController;
use App\Http\Controllers\TakmicenjaController;
use App\Http\Controllers\SudijeController;
use App\Http\Controllers\SastaviController;
use App\Http\Controllers\GoloviController;
use App\Http\Controllers\IzmeneController;
use App\Http\Controllers\KartoniController;

// Početna stranica i dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/statistika', [DashboardController::class, 'statistika'])->name('statistika');
Route::get('/kalendar', [DashboardController::class, 'kalendar'])->name('kalendar');
Route::get('/pretraga', [DashboardController::class, 'pretraga'])->name('pretraga');

// CRUD rute za timove
Route::resource('timovi', TimoviController::class);

// CRUD rute za igrače
Route::resource('igraci', IgraciController::class);

// CRUD rute za utakmice
Route::resource('utakmice', UtakmiceController::class);

Route::get('utakmice/{utakmica}', [UtakmiceController::class, 'show'])->name('utakmice.show');

// CRUD rute za stadione
Route::resource('stadioni', StadioniController::class);

// CRUD rute za takmičenja
Route::resource('takmicenja', TakmicenjaController::class);

// CRUD rute za sudije
Route::resource('sudije', SudijeController::class);

// CRUD rute za sastave
Route::resource('sastavi', SastaviController::class);

// CRUD rute za golove
Route::resource('golovi', GoloviController::class);

// CRUD rute za izmene
Route::resource('izmene', IzmeneController::class);

// CRUD rute za kartone
Route::resource('kartoni', KartoniController::class);