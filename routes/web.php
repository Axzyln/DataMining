<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\BakerInventoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IngredientDashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\VendorBrowseController;
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

    Route::get('/users',               [AdminController::class, 'users'])->name('users');
    Route::get('/users/create',        [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users',              [AdminController::class, 'storeUser'])->name('users.store');
    Route::patch('/users/{user}/role', [AdminController::class, 'updateRole'])->name('users.role');
    Route::delete('/users/{user}',     [AdminController::class, 'deleteUser'])->name('users.delete');

    Route::get('/ai-activity', [AdminController::class, 'aiActivity'])->name('ai-activity');

    Route::get('/reports',                    [AdminController::class, 'reports'])->name('reports');
    Route::get('/reports/sales.csv',          [AdminController::class, 'exportSalesCsv'])->name('reports.sales');
    Route::get('/reports/users.csv',          [AdminController::class, 'exportUsersCsv'])->name('reports.users');
    Route::get('/reports/recommendations.csv',[AdminController::class, 'exportRecommendationsCsv'])->name('reports.recommendations');

    Route::get('/settings',  [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings',  [AdminController::class, 'saveSettings'])->name('settings.save');
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
    Route::get('/dashboard',    [IngredientDashboardController::class, 'bakerDashboard'])->name('dashboard');
    Route::get('/ingredients',  [IngredientDashboardController::class, 'index'])->name('ingredients');

    Route::resource('inventory', BakerInventoryController::class)
        ->except(['show'])->parameters(['inventory' => 'inventory']);

    Route::resource('sales', SaleController::class)->except(['show', 'edit', 'update']);
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');

    Route::get('/recommendations',              [RecommendationController::class, 'index'])->name('recommendations.index');
    Route::post('/recommendations/generate',    [RecommendationController::class, 'generate'])->name('recommendations.generate');
    Route::patch('/recommendations/{recommendation}/feedback', [RecommendationController::class, 'feedback'])->name('recommendations.feedback');
    Route::get('/recommendations/history/{batchId}', [RecommendationController::class, 'batchHistory'])->name('recommendations.batch');

    Route::get('/vendors',       [VendorBrowseController::class, 'index'])->name('vendors');
    Route::get('/vendors/{vendor}', [VendorBrowseController::class, 'show'])->name('vendors.show');

    Route::resource('recipes', RecipeController::class)->except(['show'])->parameters(['recipes' => 'recipe']);
    Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');
});

/* ---------- MESSAGES (all authenticated roles) ---------- */
Route::middleware('auth')->prefix('messages')->name('messages.')->group(function () {
    Route::get('/',          [MessageController::class, 'inbox'])->name('inbox');
    Route::get('/sent',      [MessageController::class, 'sent'])->name('sent');
    Route::get('/compose',   [MessageController::class, 'compose'])->name('compose');
    Route::post('/send',     [MessageController::class, 'send'])->name('send');
    Route::get('/{message}', [MessageController::class, 'show'])->name('show');
    Route::post('/{message}/reply', [MessageController::class, 'reply'])->name('reply');
});

/* ---------- PROFILE (Breeze default) ---------- */
Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
