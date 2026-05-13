<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterClassController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/cabinet', [MasterClassController::class, 'cabinet'])->name('cabinet');
    Route::get('/master-classes/create', [MasterClassController::class, 'create'])->name('master-classes.create');
    Route::post('/master-classes', [MasterClassController::class, 'store'])->name('master-classes.store');
    Route::get('/master-classes/{id}/edit', [MasterClassController::class, 'edit'])->name('master-classes.edit');
    Route::put('/master-classes/{id}', [MasterClassController::class, 'update'])->name('master-classes.update');
    Route::delete('/master-classes/{id}', [MasterClassController::class, 'destroy'])->name('master-classes.destroy');
    Route::get('/master-classes/{id}', [MasterClassController::class, 'show'])->name('master-classes.show');

    Route::get('/registrations/{id}/confirm', [RegistrationController::class, 'confirm'])->name('registrations.confirm');
    Route::post('/registrations/{id}', [RegistrationController::class, 'store'])->name('registrations.store');
    Route::get('/my-registrations', [RegistrationController::class, 'myRegistrations'])->name('registrations.my');
});

   Route::get('/api/busy-slots', [MasterClassController::class, 'getBusySlots']);
