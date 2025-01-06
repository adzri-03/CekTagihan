<?php

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\CustomerController;

Route::redirect('/', '/login');

Route::redirect('dashboard', '/admin')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/customers/generate-pdf', [CustomerController::class, 'generatePDF'])->name('customers.generate-pdf');

require __DIR__.'/auth.php';
