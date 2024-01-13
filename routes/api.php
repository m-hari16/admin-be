<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return response()->json(['message' => 'ERROR_ACCESS']);
});

Route::post('/auth/login', 'UserManagement\AuthController@login');

Route::prefix('admin')->group(function() {
    
    Route::middleware('auth:api')->group(function() {
        Route::post('/logout', 'UserManagement\AuthController@logout');
        
        Route::get('/dashboard', 'Dashboard\DashboardController@index');
        
        Route::post('/role', 'UserManagement\RoleController@create');
        Route::get('/role', 'UserManagement\RoleController@index');
        Route::get('/role/{id}', 'UserManagement\RoleController@show');
        Route::put('/role/{id}', 'UserManagement\RoleController@update');
        Route::delete('/role/{id}', 'UserManagement\RoleController@delete');
    
        Route::post('/category', 'Product\CategoryController@create');
        Route::get('/category', 'Product\CategoryController@index');
        Route::get('/category/{id}', 'Product\CategoryController@show');
        Route::put('/category/{id}', 'Product\CategoryController@update');
        Route::delete('/category/{id}', 'Product\CategoryController@delete');
    
        Route::post('/product', 'Product\ProductController@create');
        Route::get('/product', 'Product\ProductController@index');
        Route::get('/product/{id}', 'Product\ProductController@show');
        Route::put('/product/{id}', 'Product\ProductController@update');
        Route::delete('/product/{id}', 'Product\ProductController@delete');
    
        Route::post('/stock', 'Product\StockController@create');
        Route::get('/stock', 'Product\StockController@index');
        Route::get('/stock/{id}', 'Product\StockController@show');
        Route::put('/stock/{id}', 'StockController@update');
        Route::delete('/stock/{id}', 'Product\StockController@delete');
    
        Route::post('/purchase', 'Product\PurchaseController@create');
        Route::get('/purchase', 'Product\PurchaseController@index');
        Route::get('/purchase/{id}', 'Product\PurchaseController@show');
        Route::put('/purchase/{id}', 'Product\PurchaseController@update');
        Route::delete('/purchase/{id}', 'Product\PurchaseController@delete');
    });

    Route::middleware('auth:administrator')->group(function() {
        Route::post('/user', 'UserManagement\UserController@create');
        Route::get('/user', 'UserManagement\UserController@index');
        Route::get('/user/{id}', 'UserManagement\UserController@show');
        Route::put('/user/{id}', 'UserManagement\UserController@update');
        Route::delete('/user/{id}', 'UserManagement\UserController@delete');
    });
});
