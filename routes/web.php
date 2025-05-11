<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PurchaseController;
use App\Http\Middleware\ModeratorMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;
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


// access for all users

Route::middleware([TokenVerificationMiddleWare::class])->group(function () {

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

//minimum product list
Route::get('/minimum-product-list',[ProductController::class,'minimumProductList']);


//categories
Route::get('/list-category',[CategoryController::class,'listCategory']);
Route::get('/category-save-page',[CategoryController::class,'categorySavePage']);
Route::post('/create-category',[CategoryController::class,'createCategory']);
Route::post('/update-category',[CategoryController::class,'updateCategory']);
Route::get('/delete-category',[CategoryController::class,'deleteCategory']);

//list requisitions
Route::get('/list-requisition',[RequisitionController::class,'listRequisition']);


});

//access for moderator and super admin
Route::middleware([TokenVerificationMiddleWare::class,ModeratorMiddleware::class])->group(function () {
    //requisitions

Route::get('/requisition-save-page',[RequisitionController::class,'requisitionSavePage']);
Route::post('/create-requisition',[RequisitionController::class,'createRequisition']);
Route::get('/delete-requisition',[RequisitionController::class,'deleteRequisition']);
Route::get('/requisition-product-list',[RequisitionController::class,'requisitionProductList']);
Route::post('/requisition-received-request',[RequisitionController::class,'requisitionReceivedRequest']);
});

//super admin access

Route::middleware([TokenVerificationMiddleWare::class,SuperAdminMiddleware::class])->group(function () {
      //users
    Route::get('/list-user',[UserController::class,'listUser']);
    Route::get('/user-save-page',[UserController::class,'userSavePage']);
    Route::post('/create-user',[UserController::class,'createUser']);
    Route::post('/update-user',[UserController::class,'updateUser']);
    Route::get('/delete-user',[UserController::class,'deleteUser']);

    //requisitions
    Route::get('/requisition-received-request-list',[RequisitionController::class,'requisitionReceivedRequestList']);
    Route::get('/requisition-approve-request',[RequisitionController::class,'requisitionApproveRequest']);
    Route::get('/edit-requisition-request-page',[RequisitionController::class,'editRequisitionRequestPage']);
    Route::post('/update-requisition-request',[RequisitionController::class,'updateRequisitionRequest']);

});

// admin access

Route::middleware([TokenVerificationMiddleWare::class,AdminMiddleware::class])->group(function () {
    //purchases
    Route::get('/list-purchase',[PurchaseController::class,'listPurchase']);
    Route::get('/purchase-save-page',[PurchaseController::class,'purchaseSavePage']);
    Route::post('/create-purchase',[PurchaseController::class,'createPurchase']);
    Route::post('/update-purchase',[PurchaseController::class,'updatePurchase']);
    Route::get('/delete-purchase',[PurchaseController::class,'deletePurchase']);

});




