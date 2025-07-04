<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\HomePageSectionController;
use App\Http\Controllers\CataloguePageController;
use App\Http\Controllers\AboutUsPageController;
use App\Http\Controllers\CareerPageController;
use App\Http\Controllers\CustomerCarePageController;
use App\Http\Controllers\CategoryRangeController;
use App\Http\Controllers\ProductController;

// Group all public-facing CMS APIs with API Key Middleware
Route::middleware('api.key')->group(function () {
    Route::get('/home', [HomePageSectionController::class, 'getHomeData']);
    Route::get('/catalogue', [CataloguePageController::class, 'getCataData']);
    Route::get('/about', [AboutUsPageController::class, 'getAboutData']);
    Route::get('/career', [CareerPageController::class, 'getCareerData']);
    Route::get('/customer-care', [CustomerCarePageController::class, 'getCustomerData']);
    Route::get('/get-ranges', [CategoryRangeController::class, 'getRanges']);
    Route::get('/ranges/{range}/products', [ProductController::class, 'getProductsByRange']);

});
