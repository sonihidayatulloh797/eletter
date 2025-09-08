<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Dashboard\Dashboard;


Route::view('/dashboard', 'livewire.dashboard.dashboard')->name('dashboard');
