<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\StripeController;

// Public Routes

Route::get('/', [BookController::class, 'index'])->name('home');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');




// Payment/Checkout Routes

Route::prefix('checkout')->group(function () {
    Route::post('/{book}', [StripeController::class, 'checkout'])->name('checkout');
    Route::get('/success/{book}', [StripeController::class, 'success'])->name('checkout.success');
    Route::get('/cancel/{book}', [StripeController::class, 'cancel'])->name('checkout.cancel');
});




// Admin Authentication Routes

Route::prefix('admin')->name('admin.')->group(function () {
    // Login Routes
    Route::get('/login', [AdminController::class, 'index'])
        ->name('login')
        ->middleware('guest_admin');
    
    Route::post('/login', [AdminController::class, 'login'])
        ->name('login.submit')
        ->middleware('guest_admin');

    // Register Routes
    Route::get('/register', [AdminController::class, 'create'])
        ->name('register')
        ->middleware('guest_admin');
    
    Route::post('/register', [AdminController::class, 'store'])
        ->name('register.submit')
        ->middleware('guest_admin');

    // Logout Route
    Route::post('/logout', [AdminController::class, 'logout'])
        ->name('logout')
        ->middleware('auth_admin');
});




// Admin Protected Routes

Route::middleware('auth_admin')->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('dashboard');

    // Resource Routes
    Route::resource('authors', AuthorController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);
    
    Route::resource('publishers', PublisherController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);
    
    Route::resource('books', BookController::class)
        ->only(['index', 'store', 'show', 'edit', 'update', 'destroy']);
});
