<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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

require __DIR__.'/auth.php';

Route::get('admin/dashboard', [HomeController::class, 'adminIndex'])->name('admin.dashboard');

// Add doctor panel routes
Route::get('doctor/dashboard', [HomeController::class, 'doctorIndex'])->name('doctor.dashboard');

// Add patient panel routes
Route::get('patient/dashboard', [HomeController::class, 'patientIndex'])->name('patient.dashboard');

Route::get('/users', [UserController::class, 'index'])->name('user.index');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function() {
    Route::resource('user', UserController::class);
    Route::get('users', [UserController::class, 'index'])->name('users.index'); // Add this line
});
