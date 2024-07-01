<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Middleware\AcceptedTrademarkOwnersMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteController;

Route::group([
    'middleware'=>['auth:api']
],function(){

    Route::get('/user/destroy', [UserController::class,'destroy']);

    Route::get('/me', [UserController::class,'show']);

});

Route::post('/user/create', [UserController::class,'create']);

Route::post('/user/store', [UserController::class,'store']);

Route::middleware([AcceptedTrademarkOwnersMiddleware::class, 'auth:api'])->group(function(){

    // Product
    Route::post('/product/create',[ProductController::class,'create']);

    Route::put('/product/{product_id}/edit',[ProductController::class,'edit']);

    Route::delete('/product/{product_id}/destroy',[ProductController::class,'destroy']);

    Route::get('/product/id/{product_id}',[ProductController::class,'show_by_id']);

    Route::get('/product/slug/{slug}',[ProductController::class,'show']);

    Route::get('/product/index',[ProductController::class,'index']);

    // Event
    Route::post('/event/create',[EventController::class,'create']);
});

Route::middleware(['auth:api'])->group(function(){

    // Favorite
    Route::get('/favorite/index',[FavoriteController::class,'index']);

    Route::post('/favorite/product/{product_id}',[FavoriteController::class,'create']);

    Route::get('/favorite/{favorite_id}',[FavoriteController::class,'show']);

    Route::get('/favorite/{favorite_id}/destroy',[FavoriteController::class,'destroy']);
});
