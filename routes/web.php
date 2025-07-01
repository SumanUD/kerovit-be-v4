<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Admin\HomePageSectionController;
use App\Http\Controllers\CataloguePageController;
use App\Http\Controllers\AboutUsPageController;
use App\Http\Controllers\CareerPageController;
use App\Http\Controllers\CustomerCarePageController;


// Dashboard (only accessible to logged-in users)
Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Auth routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Password reset
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');



Route::get('/register', function () {
    return redirect('/login');
});


Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/homepage', [HomePageSectionController::class, 'edit'])->name('homepage.edit');
    Route::post('/homepage', [HomePageSectionController::class, 'update'])->name('homepage.update');
    
    Route::get('/catalogue', [CataloguePageController::class, 'index'])->name('catalogue.index');
    Route::post('/catalogue/update', [CataloguePageController::class, 'update'])->name('catalogue.update');

    Route::get('/about-us', [AboutUsPageController::class, 'index'])->name('about.index');
    Route::post('/about-us', [AboutUsPageController::class, 'update'])->name('about.update');

    Route::get('career', [CareerPageController::class, 'edit'])->name('career.edit');
    Route::post('career', [CareerPageController::class, 'update'])->name('career.update');

    Route::get('customer-care', [CustomerCarePageController::class, 'edit'])->name('customer-care.edit');
    Route::post('customer-care', [CustomerCarePageController::class, 'update'])->name('customer-care.update');
});


