<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\AvailableParkingSpaceController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Customer\CustomerBookingController;
use App\Http\Controllers\Staff\StaffBookingController;

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

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('customers', CustomerController::class)->except(['show']);
    Route::resource('available-parking-spaces', AvailableParkingSpaceController::class)->except(['show']);
    Route::resource('bookings', BookingController::class)->except(['show']);
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::put('/users/{user}/role', [UserManagementController::class, 'updateRole'])->name('users.updateRole');

    Route::get('/bookings/pdf', [BookingController::class, 'downloadPDF'])->name('bookings.pdf');
    Route::get('/available-parking-spaces/pdf', [AvailableParkingSpaceController::class, 'downloadPDF'])->name('available_parking_spaces.pdf');
    Route::get('/customers/pdf', [CustomerController::class, 'downloadPDF'])->name('customers.pdf');
});

Route::middleware(['auth', 'role:user'])->prefix('customer')->name('customer.')->group(function () {
    Route::resource('bookings', CustomerBookingController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::get('/bookings/pdf', [CustomerBookingController::class, 'downloadPDF'])->name('bookings.pdf');
    Route::get('/notifications', [CustomerBookingController::class, 'notifications'])->name('notifications');
});

Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff/bookings', [StaffBookingController::class, 'index'])->name('staff.bookings.index');
    Route::post('/staff/bookings/{booking}/confirm', [StaffBookingController::class, 'confirm'])->name('staff.bookings.confirm');
    Route::get('/staff/bookings/confirmed', [StaffBookingController::class, 'confirmedBookings'])->name('staff.bookings.confirmed');
    Route::get('/staff/bookings/pdf', [StaffBookingController::class, 'downloadPDF'])->name('staff.bookings.pdf');
});

require __DIR__.'/auth.php';

