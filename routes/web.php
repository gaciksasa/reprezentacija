<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UtakmiceController;
use App\Http\Controllers\TimoviController;
use App\Http\Controllers\IgraciController;
use App\Http\Controllers\TakmicenjaController;
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
use App\Http\Controllers\PostController;
use App\Http\Controllers\KategorijaController;

// Login routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Register routes - protected
Route::middleware('auth')->group(function() {
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User profile routes - protected
Route::middleware('auth')->group(function() {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
});

// User management - protected
Route::middleware('auth')->resource('users', UserController::class);

// CRUD for teams - protected
Route::middleware('auth')->group(function() {
    Route::get('/timovi/create', [TimoviController::class, 'create'])->name('timovi.create');
    Route::post('/timovi', [TimoviController::class, 'store'])->name('timovi.store');
    Route::get('/timovi/{tim}/edit', [TimoviController::class, 'edit'])->name('timovi.edit');
    Route::put('/timovi/{tim}', [TimoviController::class, 'update'])->name('timovi.update');
    Route::delete('/timovi/{tim}', [TimoviController::class, 'destroy'])->name('timovi.destroy');
});

// Tim varijante routes - protected
Route::middleware('auth')->group(function() {
    Route::resource('tim-varijante', TimVarijanteController::class)->except(['show']);
    Route::post('tim-varijante/postavi-glavni-tim/{tim}', [TimVarijanteController::class, 'postaviGlavniTim'])->name('tim-varijante.postaviGlavniTim');
});

// CRUD for players - protected
Route::middleware('auth')->group(function() {
    Route::get('/igraci/create', [IgraciController::class, 'create'])->name('igraci.create');
    Route::post('/igraci', [IgraciController::class, 'store'])->name('igraci.store');
    Route::get('/igraci/{igrac}/edit', [IgraciController::class, 'edit'])->name('igraci.edit');
    Route::put('/igraci/{igrac}', [IgraciController::class, 'update'])->name('igraci.update');
    Route::delete('/igraci/{igrac}', [IgraciController::class, 'destroy'])->name('igraci.destroy');
    Route::post('igraci/{igrac}/update-club', [IgraciController::class, 'updateClub'])->name('igraci.updateClub');
    Route::delete('bivsi-klubovi/{klub}', [IgraciController::class, 'deleteClub'])->name('igraci.deleteClub');
});

// CRUD for matches - protected
Route::middleware('auth')->group(function() {
    Route::get('/utakmice/create', [UtakmiceController::class, 'create'])->name('utakmice.create');
    Route::post('/utakmice', [UtakmiceController::class, 'store'])->name('utakmice.store');
    Route::get('/utakmice/{utakmica}/edit', [UtakmiceController::class, 'edit'])->name('utakmice.edit');
    Route::put('/utakmice/{utakmica}', [UtakmiceController::class, 'update'])->name('utakmice.update');
    Route::delete('/utakmice/{utakmica}', [UtakmiceController::class, 'destroy'])->name('utakmice.destroy');
});

// CRUD for coaches - protected
Route::middleware('auth')->group(function() {
    Route::get('/selektori/create', [SelektoriController::class, 'create'])->name('selektori.create');
    Route::post('/selektori', [SelektoriController::class, 'store'])->name('selektori.store');
    Route::get('/selektori/{selektor}/edit', [SelektoriController::class, 'edit'])->name('selektori.edit');
    Route::put('/selektori/{selektor}', [SelektoriController::class, 'update'])->name('selektori.update');
    Route::delete('/selektori/{selektor}', [SelektoriController::class, 'destroy'])->name('selektori.destroy');
    Route::post('selektori/{selektor}/dodaj-mandat', [SelektoriController::class, 'dodajMandat'])->name('selektori.dodajMandat');
    Route::delete('selektor-mandati/{mandat}', [SelektoriController::class, 'obrisiMandat'])->name('selektori.obrisiMandat');
});

// CRUD for posts - protected
Route::middleware('auth')->resource('posts', PostController::class)->except(['index', 'show']);
Route::resource('posts', PostController::class)->only(['index', 'show']);

// CRUD for kategorije - protected
Route::middleware('auth')->resource('kategorije', KategorijaController::class)->except(['index', 'show']);
Route::resource('kategorije', KategorijaController::class)->only(['index', 'show']);

// CRUD for opponent coaches - protected
Route::middleware('auth')->resource('protivnicki-selektori', ProtivnickiSelektoriController::class)->except(['index', 'show']);

// CRUD for competitions - protected
Route::middleware('auth')->resource('takmicenja', TakmicenjaController::class)->except(['index', 'show']);

// CRUD for lineups - protected
Route::middleware('auth')->resource('sastavi', SastaviController::class)->except(['index', 'show']);
Route::resource('sastavi', SastaviController::class)->only(['index', 'show']);

// CRUD for opponent players - protected
Route::middleware('auth')->resource('protivnicki-igraci', ProtivnickiIgraciController::class);

// CRUD for goals - protected
Route::middleware('auth')->resource('golovi', GoloviController::class);

// CRUD for substitutions - protected
Route::middleware('auth')->resource('izmene', IzmeneController::class);

// CRUD for cards - protected
Route::middleware('auth')->resource('kartoni', KartoniController::class);

// Routes for opponent substitutions - protected
Route::middleware('auth')->group(function() {
    Route::get('protivnicke-izmene/{id}/edit', [ProtivnickeIzmeneController::class, 'edit'])->name('protivnicke-izmene.edit');
    Route::put('protivnicke-izmene/{id}', [ProtivnickeIzmeneController::class, 'update'])->name('protivnicke-izmene.update');
    Route::delete('protivnicke-izmene/{id}', [ProtivnickeIzmeneController::class, 'destroy'])->name('protivnicke-izmene.destroy');
});

// Routes for opponent cards - protected
Route::middleware('auth')->group(function() {
    Route::get('protivnicki-kartoni/create', [ProtivnickiKartoniController::class, 'create'])->name('protivnicki-kartoni.create');
    Route::post('protivnicki-kartoni', [ProtivnickiKartoniController::class, 'store'])->name('protivnicki-kartoni.store');
    Route::delete('protivnicki-kartoni/{id}', [ProtivnickiKartoniController::class, 'destroy'])->name('protivnicki-kartoni.destroy');
});

// Update order routes - protected
Route::middleware('auth')->group(function() {
    Route::post('/sastavi/update-order', [SastaviController::class, 'updateOrder'])->name('sastavi.updateOrder');
    Route::post('/protivnicki-igraci/update-order', [ProtivnickiIgraciController::class, 'updateOrder'])->name('protivnicki-igraci.updateOrder');
});

// Public Routes
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/statistika', [DashboardController::class, 'statistika'])->name('statistika');
Route::get('/kalendar', [DashboardController::class, 'kalendar'])->name('kalendar');
Route::get('/pretraga', [DashboardController::class, 'pretraga'])->name('pretraga');
Route::get('/utakmice/dekada/{dekada}', [UtakmiceController::class, 'dekada'])->name('utakmice.dekada');

// Read-only routes
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
