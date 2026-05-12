<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\BakerInventoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IngredientDashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\VendorProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

/* ---------- ADMIN ---------- */
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/vendors',   [AdminController::class, 'vendors'])->name('vendors');
    Route::post('/vendors/{vendor}/verify', [AdminController::class, 'verifyVendor'])->name('vendors.verify');
    Route::get('/users',     [AdminController::class, 'users'])->name('users');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
});

/* ---------- VENDOR ---------- */
Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard',     [VendorProfileController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile',       [VendorProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile',      [VendorProfileController::class, 'update'])->name('profile.update');

    Route::resource('products',  ProductController::class)->except(['show']);
});

/* ---------- BAKER ---------- */
Route::middleware(['auth', 'role:baker'])->prefix('baker')->name('baker.')->group(function () {
    Route::get('/dashboard', [IngredientDashboardController::class, 'bakerDashboard'])->name('dashboard');
    Route::get('/ingredients', [IngredientDashboardController::class, 'index'])->name('ingredients');

    Route::resource('inventory', BakerInventoryController::class)
        ->except(['show'])->parameters(['inventory' => 'inventory']);

    Route::resource('sales', SaleController::class)->except(['show', 'edit', 'update']);
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');

    Route::get('/recommendations', [RecommendationController::class, 'index'])->name('recommendations.index');
    Route::post('/recommendations/generate', [RecommendationController::class, 'generate'])->name('recommendations.generate');
});

/* ---------- PROFILE (Breeze default) ---------- */
Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';