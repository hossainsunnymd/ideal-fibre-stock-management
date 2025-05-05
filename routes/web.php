<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});


//user login
Route::post('/login',[AuthController::class,'login']);

//user logout
Route::get('/logout',[AuthController::class,'logout']);

//products
Route::get('/product-stock-list',[ProductController::class,'productStockList']);
Route::get('/list-product',[ProductController::class,'listProduct']);
Route::get('/product-save-page',[ProductController::class,'productSavePage']);
Route::post('/create-product',[ProductController::class,'createProduct']);
Route::post('/update-product',[ProductController::class,'updateProduct']);
Route::get('/delete-product',[ProductController::class,'deleteProduct']);


//categories
Route::get('/list-category',[CategoryController::class,'listCategory']);
Route::get('/category-save-page',[CategoryController::class,'categorySavePage']);
Route::post('/create-category',[CategoryController::class,'createCategory']);
Route::post('/update-category',[CategoryController::class,'updateCategory']);
Route::get('/delete-category',[CategoryController::class,'deleteCategory']);
