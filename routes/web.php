<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public home page (dynamic with HomeController)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public events listing
Route::get('/events', [EventController::class, 'index'])->name('events.index');

// Event registration (requires login)
Route::post('/events/{event}/register', [EventController::class, 'register'])
    ->middleware('auth')
    ->name('events.register');

// User dashboard (Laravel Breeze default)
Route::get('/dashboard', [App\Http\Controllers\MemberDashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Authenticated user profile routes (Laravel Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/donate', function (Illuminate\Http\Request $request) {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string|in:online_transfer,cash,card'
        ]);

        \App\Models\Donation::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'donation_date' => now(),
            'payment_method' => $request->payment_method,
            'status' => 'completed'
        ]);

        return redirect()->route('dashboard')->with('success', 'Thank you for your donation! RM ' . number_format($request->amount, 2));
    })->name('donate.store');
});

// Admin routes (protected by auth + admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Event management
    Route::resource('events', EventController::class)->except(['index', 'show']);

    // Announcement management: custom admin index, plus resource except index
    Route::get('/announcements', [AnnouncementController::class, 'adminIndex'])->name('admin.announcements.index');
    Route::resource('announcements', AnnouncementController::class)->except(['index']);
});

// Include Laravel authentication routes (login, register, logout, etc.)
require __DIR__.'/auth.php';