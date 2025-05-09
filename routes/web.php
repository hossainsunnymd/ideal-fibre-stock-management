<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RequisitionController;
use App\Http\Middleware\TokenVerificationMiddleWare;

Route::get('/', function () {
    return view('welcome');
});


//user login
Route::post('/login',[AuthController::class,'login']);
Route::get('/login-page',[AuthController::class,'loginPage']);

//user logout
Route::get('/logout',[AuthController::class,'logout']);

Route::middleware([TokenVerificationMiddleWare::class])->group(function () {

    //users
    Route::get('/list-user',[UserController::class,'listUser']);
    Route::get('/user-save-page',[UserController::class,'userSavePage']);
    Route::post('/create-user',[UserController::class,'createUser']);
    Route::post('/update-user',[UserController::class,'updateUser']);
    Route::get('/delete-user',[UserController::class,'deleteUser']);


    //products
Route::get('/product-stock-list',[ProductController::class,'productStockList']);
Route::get('/list-product',[ProductController::class,'listProduct']);
Route::get('/product-save-page',[ProductController::class,'productSavePage']);
Route::post('/create-product',[ProductController::class,'createProduct']);
Route::post('/update-product',[ProductController::class,'updateProduct']);
Route::get('/delete-product',[ProductController::class,'deleteProduct']);


//issue product
Route::get('/product-issue-page',[ProductController::class,'productIssuePage']);
Route::post('/issue-product',[ProductController::class,'issueProduct']);

//issue product list
Route::get('/issue-product-list',[ProductController::class,'issueProductList']);

//damage product list
Route::get('/damage-product-list',[ProductController::class,'damageProductList']);


//categories
Route::get('/list-category',[CategoryController::class,'listCategory']);
Route::get('/category-save-page',[CategoryController::class,'categorySavePage']);
Route::post('/create-category',[CategoryController::class,'createCategory']);
Route::post('/update-category',[CategoryController::class,'updateCategory']);
Route::get('/delete-category',[CategoryController::class,'deleteCategory']);


//requisitions
Route::get('/list-requisition',[RequisitionController::class,'listRequisition']);
Route::get('/requisition-save-page',[RequisitionController::class,'requisitionSavePage']);
Route::post('/create-requisition',[RequisitionController::class,'createRequisition']);
Route::get('/delete-requisition',[RequisitionController::class,'deleteRequisition']);
Route::get('/requisition-received-request-list',[RequisitionController::class,'requisitionReceivedRequestList']);
Route::post('/requisition-received-request',[RequisitionController::class,'requisitionReceivedRequest']);
Route::get('/requisition-approve-request',[RequisitionController::class,'requisitionApproveRequest']);
Route::get('/requisition-product-list',[RequisitionController::class,'requisitionProductList']);

//purchases
Route::get('/list-purchase',[ProductController::class,'listPurchase']);
Route::get('/purchase-save-page',[ProductController::class,'purchaseSavePage']);
Route::post('/create-purchase',[ProductController::class,'createPurchase']);
Route::post('/update-purchase',[ProductController::class,'updatePurchase']);
Route::get('/delete-purchase',[ProductController::class,'deletePurchase']);


});

