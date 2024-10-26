<?php

use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\RecipientController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('smses', 'smses')
    ->middleware(['auth'])
    ->name('smses');

Route::get('recipients', [RecipientController::class, 'index'])
    ->middleware(['auth'])
    ->name('recipients');

Route::view('recipient-groups', 'recipient-groups')
    ->middleware(['auth'])
    ->name('recipient-groups');

Route::get('/change-lang/{locale}', [LocalizationController::class, 'setLanguage']);


require __DIR__ . '/auth.php';
