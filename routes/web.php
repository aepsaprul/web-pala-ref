<?php

use App\Http\Controllers\Admin\PetaniController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:administrator'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return '<h1>Selamat Datang di Dashboard Admin</h1>';
    });
    
    // route untuk mengelola petani
    Route::resource('/admin/petani', PetaniController::class)->names('admin.petani');
});

// Hanya bisa diakses oleh user yang sudah login dan memiliki peran 'petani'
Route::middleware(['auth', 'role:petani'])->group(function () {
    Route::get('/petani/dashboard', function () {
        return '<h1>Selamat Datang di Dashboard Petani</h1>';
    });
});

// Bisa diakses oleh lebih dari satu peran
Route::middleware(['auth', 'role:administrator,pedagang'])->group(function () {
    Route::get('/laporan/transaksi', function () {
        return '<h1>Halaman Laporan Transaksi</h1>';
    });
});

require __DIR__.'/auth.php';
