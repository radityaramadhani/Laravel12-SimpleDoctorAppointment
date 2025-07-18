<?php

use Illuminate\Support\Facades\Route;
use App\livewire\PatientManager;
use App\livewire\DoctorManager;
use App\livewire\AppointmentManager;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/patients', PatientManager::class)
    ->middleware(['auth', 'verified'])
    ->name('patients');

Route::get('/doctors', DoctorManager::class)
    ->middleware(['auth', 'verified'])
    ->name('doctors');

Route::get('/appointments', AppointmentManager::class)
    ->middleware(['auth', 'verified'])
    ->name('appointments');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

// routes/web.php

// use Illuminate\Support\Facades\Route;
// use App\Livewire\PatientManager; // Jangan lupa tambahkan ini di atas

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// // TAMBAHKAN RUTE BARU DI SINI
// Route::get('/patients', PatientManager::class)
//     ->middleware(['auth', 'verified'])
//     ->name('patients');


// Route::view('profile', 'profile')
//     ->middleware(['auth'])
//     ->name('profile');

// require __DIR__.'/auth.php';
