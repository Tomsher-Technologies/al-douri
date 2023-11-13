<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;


Route::group(['prefix' => 'auth'], function ($router) {
    Route::get('/countries', [ApiController::class, 'getCountries'])->name('countries');
    Route::get('/state/{country_id?}', [ApiController::class, 'getCountryStates'])->name('state');

    Route::post('/forgot-password', [ApiController::class, 'forgotPassword'])->name('forgot-password');
});

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    
    Route::post('/login', [ApiAuthController::class, 'login'])->name('login');
    Route::post('/otp-login', [ApiAuthController::class, 'loginWithOTP'])->name('otp-login');
    Route::post('/register', [ApiAuthController::class, 'signup'])->name('register');

    Route::post('/verify-otp', [ApiAuthController::class, 'verifyOTP'])->name('verify-otp');
    Route::post('/resend-otp', [ApiAuthController::class, 'resendOTP'])->name('resend-otp');
   
    Route::get('/user-profile', [ApiAuthController::class, 'userProfile'])->name('user-profile'); 
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('logout', [ApiAuthController::class, 'logout']);
        Route::get('user-profile', [ApiAuthController::class, 'user']);
        Route::post('update-profile', [ApiAuthController::class, 'updateProfile'])->name('update-profile');
        Route::post('change-password', [ApiAuthController::class, 'changePassword'])->name('change-password');
        // Route::post('add-address', [ApiAuthController::class, 'addAddress'])->name('add-address');
        // Route::post('update-address', [ApiAuthController::class, 'updateAddress'])->name('update-address');
        // Route::post('set-default-address', [ApiAuthController::class, 'setDefaultAddress'])->name('set-default-address');
        // Route::post('delete-address', [ApiAuthController::class, 'deleteAddress'])->name('delete-address');
        Route::post('/update-profile-image', [ApiAuthController::class, 'updateProfileImage'])->name('update-profile-image');
        Route::get('home-categories', [ApiAuthController::class, 'categories'])->name('home-categories');
        Route::get('brands', [ApiAuthController::class, 'getAllBrands'])->name('brands');
        Route::get('home-products', [ApiAuthController::class, 'homeProducts'])->name('home-products');

        Route::get('week-deals', [ApiAuthController::class, 'dealOfWeekListing'])->name('week-deals');
    });

});

Route::fallback(function () {
    return response()->json([
        'data' => [],
        'success' => false,
        'status' => 404,
        'message' => 'Invalid Route'
    ]);
});
