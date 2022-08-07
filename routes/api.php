<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\UserSearchController;
use App\Http\Controllers\Api\ProductSearchController;
use App\Http\Controllers\Api\CategorySearchController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user/search', UserSearchController::class);
    Route::get('category/search', CategorySearchController::class);
    Route::get('product/search', ProductSearchController::class);


    Route::apiResource('user', UserController::class);
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('product', ProductController::class);
});
