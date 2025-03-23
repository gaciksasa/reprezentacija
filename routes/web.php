<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UtakmiceController;
use App\Http\Controllers\TimoviController;
use App\Http\Controllers\IgraciController;
use App\Http\Controllers\StadioniController;
use App\Http\Controllers\TakmicenjaController;
use App\Http\Controllers\SudijeController;
use App\Http\Controllers\SastaviController;
use App\Http\Controllers\SelektoriController;
use App\Http\Controllers\ProtivnickiSelektoriController;
use App\Http\Controllers\ProtivnickiIgraciController;
use App\Http\Controllers\ProtivnickiKartoniController;
use App\Http\Controllers\ProtivnickeIzmeneController;
use App\Http\Controllers\GoloviController;
use App\Http\Controllers\IzmeneController;
use App\Http\Controllers\KartoniController;
use App\Http\Controllers\TimVarijanteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

use App\Http\Middleware\AdminMiddleware;
// use App\Http\Middleware\EditorMiddleware;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // User profile routes (available to all logged-in users)
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
});

// Public Routes (no authentication required)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/statistika', [DashboardController::class, 'statistika'])->name('statistika');
Route::get('/kalendar', [DashboardController::class, 'kalendar'])->name('kalendar');
Route::get('/pretraga', [DashboardController::class, 'pretraga'])->name('pretraga');

// Read-only routes (public)
Route::get('/timovi', [TimoviController::class, 'index'])->name('timovi.index');
Route::get('/timovi/{tim}', [TimoviController::class, 'show'])->name('timovi.show');
Route::get('/igraci', [IgraciController::class, 'index'])->name('igraci.index');
Route::get('/igraci/{igrac}', [IgraciController::class, 'show'])->name('igraci.show');
Route::get('/utakmice', [UtakmiceController::class, 'index'])->name('utakmice.index');
Route::get('/utakmice/{utakmica}', [UtakmiceController::class, 'show'])->name('utakmice.show');
Route::get('/selektori', [SelektoriController::class, 'index'])->name('selektori.index');
Route::get('/selektori/{selektor}', [SelektoriController::class, 'show'])->name('selektori.show');
Route::get('/takmicenja', [TakmicenjaController::class, 'index'])->name('takmicenja.index');
Route::get('/takmicenja/{takmicenje}', [TakmicenjaController::class, 'show'])->name('takmicenja.show');
Route::get('/stadioni', [StadioniController::class, 'index'])->name('stadioni.index');
Route::get('/stadioni/{stadion}', [StadioniController::class, 'show'])->name('stadioni.show');
Route::get('/sudije', [SudijeController::class, 'index'])->name('sudije.index');
Route::get('/sudije/{sudija}', [SudijeController::class, 'show'])->name('sudije.show');

// User management (admin only)
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::resource('users', UserController::class);
});

// Editor Routes (admin only)
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    // CRUD for teams
    Route::get('/timovi/create', [TimoviController::class, 'create'])->name('timovi.create');
    Route::post('/timovi', [TimoviController::class, 'store'])->name('timovi.store');
    Route::get('/timovi/{tim}/edit', [TimoviController::class, 'edit'])->name('timovi.edit');
    Route::put('/timovi/{tim}', [TimoviController::class, 'update'])->name('timovi.update');
    Route::delete('/timovi/{tim}', [TimoviController::class, 'destroy'])->name('timovi.destroy');

    // Tim varijante routes
    Route::resource('tim-varijante', TimVarijanteController::class)->except(['show']);
    Route::post('tim-varijante/postavi-glavni-tim/{tim}', [TimVarijanteController::class, 'postaviGlavniTim'])->name('tim-varijante.postaviGlavniTim');
    
    // CRUD for players
    Route::get('/igraci/create', [IgraciController::class, 'create'])->name('igraci.create');
    Route::post('/igraci', [IgraciController::class, 'store'])->name('igraci.store');
    Route::get('/igraci/{igrac}/edit', [IgraciController::class, 'edit'])->name('igraci.edit');
    Route::put('/igraci/{igrac}', [IgraciController::class, 'update'])->name('igraci.update');
    Route::delete('/igraci/{igrac}', [IgraciController::class, 'destroy'])->name('igraci.destroy');
    Route::post('igraci/{igrac}/update-club', [IgraciController::class, 'updateClub'])->name('igraci.updateClub');
    Route::delete('bivsi-klubovi/{klub}', [IgraciController::class, 'deleteClub'])->name('igraci.deleteClub');

    // CRUD for matches
    Route::get('/utakmice/create', [UtakmiceController::class, 'create'])->name('utakmice.create');
    Route::post('/utakmice', [UtakmiceController::class, 'store'])->name('utakmice.store');
    Route::get('/utakmice/{utakmica}/edit', [UtakmiceController::class, 'edit'])->name('utakmice.edit');
    Route::put('/utakmice/{utakmica}', [UtakmiceController::class, 'update'])->name('utakmice.update');
    Route::delete('/utakmice/{utakmica}', [UtakmiceController::class, 'destroy'])->name('utakmice.destroy');

    // CRUD for coaches
    Route::get('/selektori/create', [SelektoriController::class, 'create'])->name('selektori.create');
    Route::post('/selektori', [SelektoriController::class, 'store'])->name('selektori.store');
    Route::get('/selektori/{selektor}/edit', [SelektoriController::class, 'edit'])->name('selektori.edit');
    Route::put('/selektori/{selektor}', [SelektoriController::class, 'update'])->name('selektori.update');
    Route::delete('/selektori/{selektor}', [SelektoriController::class, 'destroy'])->name('selektori.destroy');
    Route::post('selektori/{selektor}/dodaj-mandat', [SelektoriController::class, 'dodajMandat'])->name('selektori.dodajMandat');
    Route::delete('selektor-mandati/{mandat}', [SelektoriController::class, 'obrisiMandat'])->name('selektori.obrisiMandat');

    // CRUD for opponent coaches
    Route::resource('protivnicki-selektori', ProtivnickiSelektoriController::class)->except(['index', 'show']);

    // CRUD for stadiums
    Route::resource('stadioni', StadioniController::class)->except(['show']);

    // CRUD for competitions
    Route::resource('takmicenja', TakmicenjaController::class)->except(['show']);

    // CRUD for referees
    Route::resource('sudije', SudijeController::class)->except(['show']);

    // CRUD for lineups
    Route::resource('sastavi', SastaviController::class);

    // CRUD for opponent players
    Route::resource('protivnicki-igraci', ProtivnickiIgraciController::class);

    // CRUD for goals
    Route::resource('golovi', GoloviController::class);

    // CRUD for substitutions
    Route::resource('izmene', IzmeneController::class);

    // CRUD for cards
    Route::resource('kartoni', KartoniController::class);

    // Routes for opponent substitutions
    Route::get('protivnicke-izmene/{id}/edit', [ProtivnickeIzmeneController::class, 'edit'])->name('protivnicke-izmene.edit');
    Route::put('protivnicke-izmene/{id}', [ProtivnickeIzmeneController::class, 'update'])->name('protivnicke-izmene.update');
    Route::delete('protivnicke-izmene/{id}', [ProtivnickeIzmeneController::class, 'destroy'])->name('protivnicke-izmene.destroy');

    // Routes for opponent cards
    Route::get('protivnicki-kartoni/create', [ProtivnickiKartoniController::class, 'create'])->name('protivnicki-kartoni.create');
    Route::post('protivnicki-kartoni', [ProtivnickiKartoniController::class, 'store'])->name('protivnicki-kartoni.store');
    Route::delete('protivnicki-kartoni/{id}', [ProtivnickiKartoniController::class, 'destroy'])->name('protivnicki-kartoni.destroy');
});