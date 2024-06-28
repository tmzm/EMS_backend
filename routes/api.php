<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AcceptedTrademarkOwnersMiddleware;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware'=>['auth:api']
],function(){

    Route::get('/user/destroy', [UserController::class,'destroy']);

//    Route::get('/user/refreshToken', [UserController::class,'refresh_token']);

    Route::get('/me', [UserController::class,'show']);

});

//Route::post('/user/refresh_password', [UserController::class,'refresh_password']);

Route::post('/user/create', [UserController::class,'create']);

Route::post('/user/store', [UserController::class,'store']);

Route::group([
    'middleware'=>['auth:api']
],function(){

    Route::post('/product/create',[ProductController::class,'create']);

    Route::get('/product/id/{product_id}',[ProductController::class,'show_by_id']);

    Route::get('/product/slug/{slug}',[ProductController::class,'show']);

    Route::get('/product/index',[ProductController::class,'index']);

})->middleware([AcceptedTrademarkOwnersMiddleware::class]);

