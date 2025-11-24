<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DebateController;

// --- Public Frontend Routes ---
Route::get('/', function () {
    return view('welcome');
})->name('home');

// --- Auth Routes (for the Popup) ---
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login'); // Ajax login
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Admin LOGIN Routes (Public) ---
// This serves the login page when you hit /admin
Route::get('/admin', [AuthController::class, 'showAdminLogin'])->name('admin.login.page')->middleware('guest');
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.submit');

// --- Admin DASHBOARD Routes (Protected) ---
// Note: We changed prefix from 'admin' to 'admin-panel' or kept logic inside to avoid conflict with /admin login route
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');

    // Users Management (With Filter Support)
    Route::get('/users/{role?}', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users/{id}/approve', [AdminController::class, 'approveUser'])->name('admin.users.approve');
    Route::delete('/users/{id}/reject', [AdminController::class, 'rejectUser'])->name('admin.users.reject');

    // Debates Management
    Route::get('/debates', [AdminController::class, 'debates'])->name('admin.debates');
    Route::delete('/debates/{id}', [AdminController::class, 'deleteDebate'])->name('admin.debates.delete');
});

// --- User/Debate Routes ---
Route::middleware(['auth', 'approved'])->group(function () {
    Route::get('/debates', [DebateController::class, 'index'])->name('debates.index');
    Route::get('/debates/create', [DebateController::class, 'create'])->name('debates.create');
    Route::post('/debates', [DebateController::class, 'store'])->name('debates.store');
    Route::get('/debates/{debate}', [DebateController::class, 'show'])->name('debates.show');
    Route::post('/debates/{debate}/join', [DebateController::class, 'join'])->name('debates.join');
    Route::post('/debates/{debate}/argument', [DebateController::class, 'submitArgument'])->name('debates.argument');
    Route::post('/debates/{debate}/winner', [DebateController::class, 'declareWinner'])->name('debates.winner');
});