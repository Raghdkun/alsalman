<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CognitoFormController;

// Public route
Route::get('/', function () {
    return view('welcome'); // Public page
});

Route::get('/form', function () {
    return view('form'); // Public page
});

// Webhook route for receiving Cognito Forms submissions
Route::post('/webhook/cognito-form', [CognitoFormController::class, 'handleWebhook'])->name('webhook.cognito');

// Admin route (requires login)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/entries', [AdminController::class, 'showEntries'])->name('admin.entries');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
