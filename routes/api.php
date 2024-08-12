<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BoothController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventParticipateController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RepresentativeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Middleware\AcceptedTrademarkOwnersMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\RateController;
use App\Http\Middleware\AccessTokensOnly;
use App\Mail\OTPMail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

Route::group(['middleware' => ['auth:api']] ,function(){
    Route::get('/user/refresh-token', [UserController::class, 'refresh_token']);
});


// Global APIs 
Route::group([
    'middleware' =>
    [
        'auth:api',
        AccessTokensOnly::class
    ]
],function(){

    Route::get('/user/destroy', [UserController::class,'destroy']);

    Route::get('/me', [UserController::class,'show']);

    // otp
    Route::post('/otp/send-otp',[OtpController::class,'create']);

    Route::get('/otp/resend-otp',[OtpController::class,'resend']);

    Route::get('/otp/index',[OtpController::class,'index']);

    Route::post('/otp/verify',[OtpController::class,'verify']);

    // Product
    Route::get('/product/id/{product_id}',[ProductController::class,'show_by_id']);

    Route::get('/product/slug/{slug}',[ProductController::class,'show']);

    Route::get('/product/index',[ProductController::class,'index']);

    Route::get('/product/{product_id}/rate',[ProductController::class,'get_product_rate']);

    // Favorite
    Route::get('/favorite/index',[FavoriteController::class,'index']);

    Route::post('/favorite/product/{product_id}',[FavoriteController::class,'create']);

    Route::get('/favorite/{favorite_id}',[FavoriteController::class,'show']);

    Route::get('/favorite/{favorite_id}/destroy',[FavoriteController::class,'destroy']);

    // Follow
    Route::get('/follow/index',[FollowController::class,'index']);

    Route::post('/follow/create',[FollowController::class,'create']);

    Route::delete('/follow/{follow_id}/destroy',[FollowController::class,'destroy']);

    // Rate
    Route::get('/rate/index',[RateController::class,'index']);

    Route::post('/rate/product/{product_id}/create',[RateController::class,'create']);

    Route::delete('/rate/{rate_id}/destroy',[RateController::class,'destroy']);

    // Category
    Route::get('/category/index',[CategoryController::class,'index']);

    Route::get('/category/{category_id}',[CategoryController::class,'show']);

    // Report
    Route::get('/report/index',[RepresentativeController::class,'index']);

    Route::get('/report/{report_id}',[RepresentativeController::class,'show']);

    Route::delete('/report/{report_id}/destroy',[RepresentativeController::class,'destroy']);

    // Event
    Route::get('/event/index_active',[EventController::class,'index_active']);

    Route::get('/event/index',[EventController::class,'index']);

    // Activity
    Route::post('/activity/create',[ActivityController::class,'create']);

    Route::get('/activity/index',[ActivityController::class,'index']);

    Route::get('/activity/{activity_id}',[ActivityController::class,'show']);

    Route::delete('/activity/{activity_id}/destroy',[ActivityController::class,'destroy']);

    Route::get('/activity/user/{user_id}/index',[ActivityController::class,'index_of_user']);
    
});

Route::post('/user/create', [UserController::class,'create']);

Route::post('/user/store', [UserController::class,'store']);

// Trademark owner APIs
Route::middleware(
    [
        AcceptedTrademarkOwnersMiddleware::class,
        'auth:api',
        AccessTokensOnly::class
    ])->group(function(){

    // Product
    Route::post('/product/create',[ProductController::class,'create']);

    Route::put('/product/{product_id}/edit',[ProductController::class,'edit']);

    Route::delete('/product/{product_id}/destroy',[ProductController::class,'destroy']);

    // Participate in event
    Route::post('/event/{event_id}/participate',[EventParticipateController::class,'participate']);

    Route::get('/event_participate/index',[EventParticipateController::class,'index']);

    // Representative
    Route::post('/representative/create',[RepresentativeController::class,'create']);

    Route::put('/representative/{representative_id}/edit',[RepresentativeController::class,'edit']);

    Route::get('/representative/index',[RepresentativeController::class,'index']);

    Route::get('/representative/{representative_id}',[RepresentativeController::class,'show']);

    Route::delete('/representative/{representative_id}/destroy',[RepresentativeController::class,'destroy']);

    // Reports
    Route::post('/report/create',[ReportController::class,'create']);
});

// Admin APIs
Route::middleware(
    [
        \App\Http\Middleware\AdminMiddleware::class,
        'auth:api',
        AccessTokensOnly::class
    ])->group(function() {

    // Event
    Route::post('/event/create',[EventController::class,'create']);

    Route::put('/event/{event_id}/edit',[EventController::class,'edit']);

    Route::get('/event/{event_id}',[EventController::class,'show']);

    Route::delete('/event/{event_id}/destroy',[EventController::class,'destroy']);

    // Category
    Route::post('/category/create',[CategoryController::class,'create']);

    Route::put('/category/{category_id}/edit',[CategoryController::class,'edit']);

    Route::delete('/category/{category_id}/destroy',[CategoryController::class,'destroy']);

    // Booth
    Route::post('/booth/event/{event_id}/create',[BoothController::class,'create']);

    Route::put('/booth/{booth_id}/edit',[BoothController::class,'edit']);

    Route::get('/booth/event/{event_id}/index',[BoothController::class,'index']);

    Route::get('/booth/{booth_id}',[BoothController::class,'show']);

    Route::delete('/booth/{booth_id}/destroy',[BoothController::class,'destroy']);
});

// Route::middleware('auth:api')->group(function () {
//     // Email verification notice
//     Route::get('/email/verify', function (Request $request) {
//         return response()->json(['message' => 'Email verification notice.'], 200);
//     })->name('verification.notice');

//     // Email verification handler
//     Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//         $request->fulfill();

//         return response()->json(['message' => 'Email verified successfully.'], 200);
//     })->middleware(['signed'])->name('verification.verify');

//     // Resend verification email
//     Route::post('/email/verification-notification', function (Request $request) {
//         $request->user()->sendEmailVerificationNotification();

//         return response()->json(['message' => 'Verification email sent.'], 200);
//     })->name('verification.send');
// });
