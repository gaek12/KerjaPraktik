<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PerbaikanController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// Route::middleware(['auth'])->group(function () {
//     Route::resource('kendaraan', KendaraanController::class);
// });

// Route::middleware(['auth'])->group(function () {
//     Route::get('/perbaikan/cetak', [PerbaikanController::class, 'cetak'])->name('perbaikan.cetak');
//     Route::resource('perbaikan', PerbaikanController::class);
// });
// 👇 LETAKKAN INI DI ATAS sebelum grup middleware mana pun
// Letakkan ini sebelum group middleware

Route::get('/api/subkategori/{kategori}', function ($kategori) {
    $map = config('subkategori.mapping');
    $kategori = Str::lower(trim($kategori));
    $mapping = collect($map)->keyBy(fn($v, $k) => Str::lower(trim($k)));
    return response()->json($mapping->get($kategori, []));
});



Route::middleware(['auth', 'role:admin'])->group(function () {

    // KENDARAAN
    Route::get('/kendaraan/create', [KendaraanController::class, 'create'])->name('kendaraan.create');
    Route::get('/kendaraan/{kendaraan}/edit', [KendaraanController::class, 'edit'])->name('kendaraan.edit');
    Route::post('/kendaraan', [KendaraanController::class, 'store'])->name('kendaraan.store');
    Route::put('/kendaraan/{kendaraan}', [KendaraanController::class, 'update'])->name('kendaraan.update');

    // PERBAIKAN
    Route::get('/perbaikan/create', [PerbaikanController::class, 'create'])->name('perbaikan.create');
    Route::get('/perbaikan/{perbaikan}/edit', [PerbaikanController::class, 'edit'])->name('perbaikan.edit');
    Route::post('/perbaikan', [PerbaikanController::class, 'store'])->name('perbaikan.store');
    Route::put('/perbaikan/{perbaikan}', [PerbaikanController::class, 'update'])->name('perbaikan.update');

    // DELETE
    Route::delete('/kendaraan/{kendaraan}', [KendaraanController::class, 'destroy'])->name('kendaraan.destroy');
    Route::delete('/perbaikan/{perbaikan}', [PerbaikanController::class, 'destroy'])->name('perbaikan.destroy');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/perbaikan/cetak', [PerbaikanController::class, 'cetak'])->name('perbaikan.cetak');
});

Route::middleware(['auth', 'role:admin,user'])->group(function () {
    // Index Kendaraan
    Route::get('/kendaraan', [KendaraanController::class, 'index'])->name('kendaraan.index');

    // Index Perbaikan
    Route::get('/perbaikan', [PerbaikanController::class, 'index'])->name('perbaikan.index');
});


require __DIR__.'/auth.php';
