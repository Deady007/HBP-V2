<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MedicalVisitController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->usertype === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->usertype === 'doctor') {
        return redirect()->route('doctor.dashboard');
    } elseif ($user->usertype === 'patient') {
        return redirect()->route('patient.dashboard');
    } elseif ($user->usertype === 'user') {
        return redirect()->route('users.dashboard');
    } elseif ($user->usertype === 'nurse') {
        return redirect()->route('nurse.dashboard');
    } else {
        return view('dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/about-us', function () {
    return view('about-us.index');
})->name('about-us');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('medical_visit/{id}/edit', [MedicalVisitController::class, 'edit'])->name('medical_visit.edit');
    Route::patch('medical_visit/{id}', [MedicalVisitController::class, 'update'])->name('medical_visit.update');
    Route::patch('/medical_visit/{id}/approve', [MedicalVisitController::class, 'approve'])->name('medical_visit.approve');
    Route::patch('/medical_visit/{id}/update_status', [MedicalVisitController::class, 'updateStatus'])->name('medical_visit.update_status');
});

require __DIR__.'/auth.php';

Route::get('admin/dashboard', [UserController::class, 'adminDashboard'])->name('admin.dashboard');

// Add doctor panel routes
Route::get('doctor/dashboard', [HomeController::class, 'doctorIndex'])->name('doctor.dashboard');
Route::get('/doctor/medical-visits', [MedicalVisitController::class, 'getDoctorMedicalVisits'])->name('doctor.medical_visits');

// Add patient panel routes
Route::get('patient/dashboard', [HomeController::class, 'patientIndex'])->name('patient.dashboard');

// Add user panel routes
Route::get('users/dashboard', [HomeController::class, 'userIndex'])->name('users.dashboard');

// Add nurse panel routes
Route::get('nurse/dashboard', [HomeController::class, 'nurseIndex'])->name('nurse.dashboard');

Route::get('/users', [UserController::class, 'index'])->name('user.index');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function() {
    Route::resource('user', UserController::class);
    Route::get('users', [UserController::class, 'index'])->name('users.index');
});

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function() {
    Route::resource('patient', PatientController::class);
    Route::post('patient/{user}/approve', [PatientController::class, 'approve'])->name('patient.approve');
    Route::post('patient', [PatientController::class, 'store'])->name('patient.store');
    Route::put('patient/{id}/storePatientData', [PatientController::class, 'storePatientData'])->name('patient.storePatientData');
});

Route::resource('medical_visit', MedicalVisitController::class);
