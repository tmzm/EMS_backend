<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BoothController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExhibitionParticipateController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RepresentativeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExhibitionController;
use App\Http\Middleware\AcceptedTrademarkOwnersMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\TransferController;
use App\Http\Middleware\AccessTokensOnly;
use App\Http\Middleware\VerifiedEmail;

Route::group(['middleware' => ['auth:api']] ,function(){
    Route::get('/user/refresh-token', [UserController::class, 'refresh_token']);
});

// Global APIs 
Route::group([
    'middleware' =>
    [
        'auth:api',
        AccessTokensOnly::class,
        VerifiedEmail::class
    ]
],function(){

    Route::get('/user/destroy', [UserController::class,'destroy']);

    Route::get('/me', [UserController::class,'show']);

    Route::get('/user/wallet', [UserController::class,'get_wallet']);

    Route::post('/user/check_on_email', [UserController::class,'check_on_email']);


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

    // Exhibition
    Route::get('/exhibition/index_active',[ExhibitionController::class,'index_active']);

    Route::get('/exhibition/index',[ExhibitionController::class,'index']);

    // Activity
    Route::post('/activity/create',[ActivityController::class,'create']);

    Route::get('/activity/index',[ActivityController::class,'index']);

    Route::get('/activity/{activity_id}',[ActivityController::class,'show']);

    Route::delete('/activity/{activity_id}/destroy',[ActivityController::class,'destroy']);

    Route::get('/activity/user/{user_id}/index',[ActivityController::class,'index_of_user']);

    // List all trademarks
    Route::get('/trademark/index',[UserController::class,'index_trademarks']);
    
});

Route::post('/user/create', [UserController::class,'create']);

Route::post('/user/store', [UserController::class,'store']);

// Exhibition no auth APIs
Route::get('/exhibition_participate/index',[ExhibitionParticipateController::class,'index']);

Route::get('/exhibition_participate/index_active',[ExhibitionParticipateController::class,'index_active']);

Route::get('/exhibition_participate/index_ended',[ExhibitionParticipateController::class,'index_ended']);

// Trademark owner APIs
Route::middleware(
    [
        AcceptedTrademarkOwnersMiddleware::class,
        'auth:api',
        AccessTokensOnly::class,
        VerifiedEmail::class
    ])->group(function(){

    // Product
    Route::post('/product/create',[ProductController::class,'create']);

    Route::put('/product/{product_id}/edit',[ProductController::class,'edit']);

    Route::delete('/product/{product_id}/destroy',[ProductController::class,'destroy']);

    // Participate in Exhibition
    Route::post('/exhibition/{exhibition_id}/participate',[ExhibitionParticipateController::class,'participate']);

    Route::get('/exhibition_participate/{participate_id}',[ExhibitionParticipateController::class,'show']);

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
        AccessTokensOnly::class,
        VerifiedEmail::class
    ])->group(function() {

    // Exhibition
    Route::post('/exhibition/create',[ExhibitionController::class,'create']);

    Route::put('/exhibition/{exhibition_id}/edit',[ExhibitionController::class,'edit']);

    Route::get('/exhibition/{exhibition_id}',[ExhibitionController::class,'show']);

    Route::delete('/exhibition/{exhibition_id}/destroy',[ExhibitionController::class,'destroy']);

    // Category
    Route::post('/category/create',[CategoryController::class,'create']);

    Route::put('/category/{category_id}/edit',[CategoryController::class,'edit']);

    Route::delete('/category/{category_id}/destroy',[CategoryController::class,'destroy']);

    // Booth
    Route::post('/booth/exhibition/{exhibition_id}/create',[BoothController::class,'create']);

    Route::put('/booth/{booth_id}/edit',[BoothController::class,'edit']);

    Route::get('/booth/exhibition/{exhibition_id}/index',[BoothController::class,'index']);

    Route::get('/booth/{booth_id}',[BoothController::class,'show']);

    Route::delete('/booth/{booth_id}/destroy',[BoothController::class,'destroy']);

    // accept user
    Route::post('/user/{user_id}/accept',[UserController::class,'accept_trademark']);

    // pay an invoice
    Route::post('/invoice/{invoice_id}/pay',[InvoiceController::class,'pay']);

    // Transfer
    Route::post('/transfer/create', [TransferController::class,'create']);

    Route::put('/transfer/{transfer_id}/edit', [TransferController::class,'edit']);
});