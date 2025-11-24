<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DebateController;
use Illuminate\Support\Facades\Route;

// Frontend routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth routes
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Debate routes
Route::get('/debates', [DebateController::class, 'index'])->name('debates.index');
Route::get('/debates/{debate}', [DebateController::class, 'show'])->name('debates.show');

Route::middleware(['auth', 'approved'])->group(function () {
    Route::get('/debates/create', [DebateController::class, 'create'])->name('debates.create');
    Route::post('/debates', [DebateController::class, 'store'])->name('debates.store');
    Route::post('/debates/{debate}/join', [DebateController::class, 'join'])->name('debates.join');
    Route::post('/debates/{debate}/argument', [DebateController::class, 'submitArgument'])->name('debates.argument');
    Route::post('/debates/{debate}/winner', [DebateController::class, 'declareWinner'])->name('debates.winner');
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users/{id}/approve', [AdminController::class, 'approveUser'])->name('admin.users.approve');
    Route::delete('/users/{id}/reject', [AdminController::class, 'rejectUser'])->name('admin.users.reject');
    Route::get('/debates', [AdminController::class, 'debates'])->name('admin.debates');
    Route::delete('/debates/{id}', [AdminController::class, 'deleteDebate'])->name('admin.debates.delete');
});
