<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Livewire\UserManagement;
use App\Livewire\Auth\Login;


use App\Http\Livewire\Dashboard\Dashboard;

Route::get('/login', Login::class)->name('login');
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'livewire.dashboard.dashboard')->name('dashboard');
    Route::get('/manajemen-user', UserManagement::class)->name('manajemen-user');
});

