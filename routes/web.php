<?php

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\CustomerController;
use App\Livewire\Front\Hitung;
use App\Livewire\Front\ScanPage;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Models\Customer;


Route::redirect('/', '/login');

Route::redirect('dashboard', '/admin')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/customers/generate-pdf', [CustomerController::class, 'generatePDF'])->name('customers.generate-pdf');

Route::get('/index', function () {
    return view('livewire.front.index');
})->name('front.index');

Route::get('/hitung/{customer}', Hitung::class)->name('front.hitung');
Route::get('/scan', ScanPage::class)->name('front.scan');

Route::get('/download-pdf/{filename}', function ($filename) {
    return Storage::disk('public')->download($filename);
})->name('filament.download-pdf');

Route::post('/process-scan', function (Request $request) {
    
    $customer = Customer::findOrFail($request->scanned_code);

    if ($customer) {
        return response()->json([
            'success' => true,
            'redirect_url' => route('front.hitung', ['customer' => $customer]),
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Pelanggan tidak ditemukan',
    ]);
})->name('front.process-scan');


require __DIR__.'/auth.php';
