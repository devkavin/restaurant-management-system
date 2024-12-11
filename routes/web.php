<?php

use App\Http\Controllers\ConcessionController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('kitchen.dashboard');
});

Route::get('/dashboard', function () {
    // redirect to kitchen dashboard
    if (auth()->user()->hasRole('Staff|Admin')) {
        return redirect()->route('kitchen.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['role:Admin']], function () {
    Route::resource('users', UserController::class);
});

Route::group(['middleware' => ['role:Staff|Admin']], function () {
    Route::resource('concessions', ConcessionController::class);
    Route::delete('/concessions/{concession}/destroy', [ConcessionController::class, 'destroy'])->name('concessions.destroy');

    Route::resource('orders', OrderController::class);
    Route::post('orders/{order}/send-to-kitchen', [OrderController::class, 'sendToKitchen'])->name('orders.send-to-kitchen');

    Route::get('/kitchen', [KitchenController::class, 'index'])->name('kitchen.index');
    Route::get('/kitchen/dashboard', [KitchenController::class, 'dashboard'])->name('kitchen.dashboard');
    Route::get('/kitchen/orders', [KitchenController::class, 'index'])->name('kitchen.orders.index');
    Route::patch('/kitchen/orders/{order}', [KitchenController::class, 'update'])->name('kitchen.orders.update');
});

require __DIR__ . '/auth.php';
