<?php

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\CustomerController;
use App\Livewire\Front\Hitung;
use App\Livewire\Front\ScanPage;
use App\Livewire\Front\Index;
use Illuminate\Support\Facades\Storage;

Route::redirect('/', '/login');

Route::redirect('dashboard', '/admin')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/customers/generate-pdf', [CustomerController::class, 'generatePDF'])->name('customers.generate-pdf');

Route::get('/index', Index::class)->name('front.index');
Route::get('/hitung/{customer}', Hitung::class)->name('front.hitung');
Route::get('/scan', ScanPage::class)->name('front.scan');

Route::get('/download-pdf/{filename}', function ($filename) {
    return Storage::disk('public')->download($filename);
})->name('filament.download-pdf');

require __DIR__.'/auth.php';
