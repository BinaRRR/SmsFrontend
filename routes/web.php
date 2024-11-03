<?php

use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\RecipientController;
use App\Http\Controllers\RecipientGroupController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('sms', 'smses')
    ->middleware(['auth'])
    ->name('smses');

Route::get('recipient', [RecipientController::class, 'index'])
    ->middleware(['auth'])
    ->name('recipient');

Route::get('recipient/{id}', [RecipientController::class, 'specific'])
    ->middleware(['auth'])
    ->name('recipient-specific');

Route::get('recipient-group', [RecipientGroupController::class, 'index'])
    ->middleware(['auth'])
    ->name('recipient-group');

Route::get('recipient-group/{id}', [RecipientGroupController::class, 'specific'])
    ->middleware(['auth'])
    ->name('recipient-group-specific');

Route::get('/change-lang/{locale}', [LocalizationController::class, 'setLanguage']);


require __DIR__ . '/auth.php';
