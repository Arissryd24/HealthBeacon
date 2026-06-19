<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\VitalSignController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminThresholdController;
use App\Http\Controllers\Admin\AdminActivityController;
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
    // Dashboard & Pasien
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
    
    // Alerts
    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
    Route::patch('/alerts/{alert}/resolve', [AlertController::class, 'resolve'])->name('alerts.resolve');

    // Route Vital Signs (Punya Lu Tetap Aman di Sini)
    Route::get('/vital-signs/create', [VitalSignController::class, 'create'])->name('vitalsigns.create');
    Route::post('/vital-signs/store', [VitalSignController::class, 'store'])->name('vitalsigns.store');
    Route::delete('/vital-signs/{id}', [VitalSignController::class, 'destroy'])->name('vitalsigns.destroy');

    // ========================================================
    // ROUTE ADMIN ASLI PUNYA TEMEN LU (BIAR SAMA KAYAK VERCEL)
    // ========================================================
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.index');
    Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard'); // Tambahan alias
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/thresholds', [AdminThresholdController::class, 'index'])->name('admin.thresholds.index');
    // Ganti/tambahin nama routenya pake nama yang dicari sama Vue temen lu
    Route::get('/admin/activities', [AdminActivityController::class, 'index'])->name('admin.activity-logs.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';