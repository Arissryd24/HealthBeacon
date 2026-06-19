<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\VitalSignController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
    Route::patch('/alerts/{alert}/resolve', [AlertController::class, 'resolve'])->name('alerts.resolve');

    // Route Vital Signs
    Route::get('/vital-signs/create', [VitalSignController::class, 'create'])->name('vitalsigns.create');
    Route::post('/vital-signs/store', [VitalSignController::class, 'store'])->name('vitalsigns.store');
    Route::delete('/vital-signs/{id}', [VitalSignController::class, 'destroy'])->name('vitalsigns.destroy');

    // ==========================================
    // TAMBAHAN ROUTE BIAR MODUL ADMIN GAK 404
    // ==========================================
    // Skenario 1: Kalau modul admin lu cuma render file Vue langsung (tanpa Controller rumit)
    Route::get('/admin', function () {
        return Inertia::render('Admin/Index'); // Sesuaikan sama folder Admin.vue lu di resources/js/Pages/
    })->name('admin.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';