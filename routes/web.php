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
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\BlogController;

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

    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('/blogs/create', [BlogController::class, 'manage'])->name('blogs.create');
    Route::post('/blogs', [BlogController::class, 'storeOrUpdate'])->name('blogs.store');
    Route::get('/blogs/{blog}/edit', [BlogController::class, 'manage'])->name('blogs.edit');
    Route::put('/blogs/{blog}', [BlogController::class, 'storeOrUpdate'])->name('blogs.update');
    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');


    // All Products Start

    // Collection
    Route::resource('collections', \App\Http\Controllers\CollectionController::class);
    // Categories
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    // Ranges
    // Route::resource('ranges', \App\Http\Controllers\RangeController::class);
    // Route::post('ranges/reorder', [\App\Http\Controllers\RangeController::class, 'reorder'])->name('ranges.reorder');


     // View all ranges under a category
    Route::get('categories/{category}/ranges', [\App\Http\Controllers\CategoryRangeController::class, 'index'])
        ->name('categories.ranges.index');

    // Create form
    Route::get('categories/{category}/ranges/create', [\App\Http\Controllers\CategoryRangeController::class, 'create'])
        ->name('categories.ranges.create');

    // Store new range
    Route::post('categories/{category}/ranges/store', [\App\Http\Controllers\CategoryRangeController::class, 'store'])
        ->name('categories.ranges.store');

    // Edit form
    Route::get('categories/{category}/ranges/{range}/edit', [\App\Http\Controllers\CategoryRangeController::class, 'edit'])
        ->name('categories.ranges.edit');

    // Update range
    Route::put('categories/{category}/ranges/{range}', [\App\Http\Controllers\CategoryRangeController::class, 'update'])
        ->name('categories.ranges.update');

    // Delete range
    Route::delete('categories/{category}/ranges/{range}', [\App\Http\Controllers\CategoryRangeController::class, 'destroy'])
        ->name('categories.ranges.destroy');

    // Reorder ranges via drag-drop
    Route::post('categories/{category}/ranges/reorder', [\App\Http\Controllers\CategoryRangeController::class, 'reorder'])
        ->name('categories.ranges.reorder');

    // Product CRUD

    // Product Routes under a Range
    Route::prefix('ranges/{range}/products')->name('ranges.products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('{product}', [ProductController::class, 'destroy'])->name('destroy');
        Route::post('reorder', [ProductController::class, 'reorder'])->name('reorder');
    });


    // variant products
    Route::resource('products.variants', VariantController::class);

});



