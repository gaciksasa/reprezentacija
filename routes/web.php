<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UtakmicaEditorController;
use App\Http\Controllers\TimoviController;
use App\Http\Controllers\IgraciController;
use App\Http\Controllers\UtakmiceController;
use App\Http\Controllers\StadioniController;
use App\Http\Controllers\TakmicenjaController;
use App\Http\Controllers\SudijeController;
use App\Http\Controllers\SastaviController;
use App\Http\Controllers\ProtivnickiIgraciController;
use App\Http\Controllers\GoloviController;
use App\Http\Controllers\IzmeneController;
use App\Http\Controllers\KartoniController;


// Unified Match Editor routes
Route::get('/utakmice/kreiranje', [UtakmicaEditorController::class, 'create'])->name('utakmice.kreiranje');
Route::post('/utakmice/sacuvaj', [UtakmicaEditorController::class, 'store'])->name('utakmice.sacuvaj');
Route::get('/utakmice/{utakmica}/editor', [UtakmicaEditorController::class, 'edit'])->name('utakmice.editor');
Route::put('/utakmice/{utakmica}/azuriraj', [UtakmicaEditorController::class, 'update'])->name('utakmice.azuriraj');
Route::get('/utakmice/ucitaj-igrace', [UtakmicaEditorController::class, 'ucitajIgrace'])->name('utakmice.ucitajIgrace');

// Početna stranica i dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/statistika', [DashboardController::class, 'statistika'])->name('statistika');
Route::get('/kalendar', [DashboardController::class, 'kalendar'])->name('kalendar');
Route::get('/pretraga', [DashboardController::class, 'pretraga'])->name('pretraga');

// CRUD rute za timove
Route::resource('timovi', TimoviController::class, ['parameters' => [
    'timovi' => 'tim'
]]);

// Tim varijante routes
Route::resource('tim-varijante', TimVarijanteController::class)->except(['show']);
Route::post('tim-varijante/postavi-glavni-tim/{tim}', [TimVarijanteController::class, 'postaviGlavniTim'])->name('tim-varijante.postaviGlavniTim');

// Tim varijante routes
Route::resource('tim-varijante', TimVarijanteController::class)->except(['show']);
Route::post('tim-varijante/postavi-glavni-tim/{tim}', [TimVarijanteController::class, 'postaviGlavniTim'])->name('tim-varijante.postaviGlavniTim');

// CRUD rute za igrače
Route::resource('igraci', IgraciController::class, ['parameters' => [
    'igraci' => 'igrac'
]]);
Route::post('igraci/{igrac}/update-club', [IgraciController::class, 'updateClub'])->name('igraci.updateClub');
Route::delete('bivsi-klubovi/{klub}', [IgraciController::class, 'deleteClub'])->name('igraci.deleteClub');

// CRUD rute za protivničke igrače
Route::resource('protivnicki-igraci', ProtivnickiIgraciController::class);

// CRUD rute za utakmice
Route::resource('utakmice', UtakmiceController::class);
Route::get('utakmice/{utakmica}', [UtakmiceController::class, 'show'])->name('utakmice.show');

// CRUD rute za selektore
Route::resource('selektori', SelektoriController::class);
Route::post('selektori/{selektor}/dodaj-mandat', [SelektoriController::class, 'dodajMandat'])->name('selektori.dodajMandat');
Route::delete('selektor-mandati/{mandat}', [SelektoriController::class, 'obrisiMandat'])->name('selektori.obrisiMandat');

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