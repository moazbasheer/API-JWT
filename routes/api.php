<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\User\AuthController as UserController;
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

Route::group(['namespace' => 'Api'], function() {
    Route::post('/get-main-categories', [CategoriesController::class, 'index']);
    Route::post('/get-category-ById', [CategoriesController::class, 'getCategoryById']);
    Route::post('/change-status', [CategoriesController::class, 'changeStatus']);
    
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('checkAdminToken:admin-api');
    });

    Route::group(['prefix' => 'user', 'namespace' => 'User'], function() {
        Route::post('/login', [UserController::class, 'login']);
        Route::post('/logout', [UserController::class, 'logout'])->middleware('checkAdminToken:user-api');
    });
});
Route::group(['middleware' => 'checkAdminToken:admin-api', 'namespace' => 'Api'], function() {
    Route::post('/offers', function() {
        return \Auth::guard('admin-api')->user();
    });
});

Route::group(['prefix' => 'user', 'middleware' => ['api', 'checkPassword', 'changeLanguage', 'checkAdminToken:user-api'], 'namespace' => 'Api'], function() {
    Route::post('/profile', function() {
        return \Auth::guard('user-api')->user();
    });
});