<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AcceptedTrademarkOwnersMiddleware;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware'=>['auth:api']
],function(){

    Route::get('/user/destroy', [UserController::class,'destroy']);

});

Route::post('/user/refresh_password', [UserController::class,'refresh_password']);

Route::post('/user/create', [UserController::class,'create']);

Route::post('/user/store', [UserController::class,'store']);

Route::group([
    'middleware'=>['auth:api']
],function(){

    Route::resource(ProductController::class,'destroy')->except(['index']);

})->middleware([AcceptedTrademarkOwnersMiddleware::class]);

