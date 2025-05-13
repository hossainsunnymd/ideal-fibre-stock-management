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




//user login
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/', [AuthController::class, 'loginPage'])->name('loginPage');

//user logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// access for all users
Route::middleware([TokenVerificationMiddleWare::class])->group(function () {

    //products
    Route::get('/product-stock-list', [ProductController::class, 'productStockList'])->name('product.stock.list');
    Route::get('/list-product', [ProductController::class, 'listProduct'])->name('product.list');
    Route::post('/create-product', [ProductController::class, 'createProduct'])->name('product.create');


    //issue product
    Route::get('/product-issue-page', [ProductController::class, 'productIssuePage'])->name('product.issue.page');
    Route::post('/issue-product', [ProductController::class, 'issueProduct'])->name('product.issue');

    //issue product list
    Route::get('/issue-product-list', [ProductController::class, 'issueProductList'])->name('product.issue.list');

    //damage product list
    Route::get('/damage-product-list', [ProductController::class, 'damageProductList'])->name('product.damage.list');

    //minimum product list
    Route::get('/minimum-product-list', [ProductController::class, 'minimumProductList'])->name('product.minimum.list');

    //categories
    Route::get('/list-category', [CategoryController::class, 'listCategory'])->name('category.list');
    Route::post('/create-category', [CategoryController::class, 'createCategory'])->name('category.create');


    //list requisitions
    Route::get('/list-requisition', [RequisitionController::class, 'listRequisition'])->name('requisition.list');
});

//access for moderator and super admin
Route::middleware([TokenVerificationMiddleWare::class, ModeratorMiddleware::class])->group(function () {

    //requisitions
    Route::get('/requisition-save-page', [RequisitionController::class, 'requisitionSavePage'])->name('requisition.save.page');
    Route::post('/create-requisition', [RequisitionController::class, 'createRequisition'])->name('requisition.create');
    Route::get('/requisition-product-list', [RequisitionController::class, 'requisitionProductList'])->name('requisition.product.list');
    Route::post('/requisition-received-request', [RequisitionController::class, 'requisitionReceivedRequest'])->name('requisition.received.request');
});

//super admin access
Route::middleware([TokenVerificationMiddleWare::class, SuperAdminMiddleware::class])->group(function () {

    //users
    Route::get('/list-user', [UserController::class, 'listUser'])->name('user.list');
    Route::get('/user-save-page', [UserController::class, 'userSavePage'])->name('user.save.page');
    Route::post('/create-user', [UserController::class, 'createUser'])->name('user.create');
    Route::post('/update-user', [UserController::class, 'updateUser'])->name('user.update');
    Route::get('/delete-user', [UserController::class, 'deleteUser'])->name('user.delete');

    //requisitions
    Route::get('/requisition-received-request-list', [RequisitionController::class, 'requisitionReceivedRequestList'])->name('requisition.received.request.list');
    Route::get('/requisition-approve-request', [RequisitionController::class, 'requisitionApproveRequest'])->name('requisition.approve.request');
    Route::get('/edit-requisition-request-page', [RequisitionController::class, 'editRequisitionRequestPage'])->name('requisition.edit.request.page');
    Route::post('/update-requisition-request', [RequisitionController::class, 'updateRequisitionRequest'])->name('requisition.update.request');
    Route::get('/delete-requisition', [RequisitionController::class, 'deleteRequisition'])->name('requisition.delete');
});

// access for admin and super admin
Route::middleware([TokenVerificationMiddleWare::class, AdminMiddleware::class])->group(function () {

    //purchases
    Route::get('/list-purchase', [PurchaseController::class, 'listPurchase'])->name('purchase.list');
    Route::get('/purchase-save-page', [PurchaseController::class, 'purchaseSavePage'])->name('purchase.save.page');
    Route::post('/create-purchase', [PurchaseController::class, 'createPurchase'])->name('purchase.create');
    Route::post('/update-purchase', [PurchaseController::class, 'updatePurchase'])->name('purchase.update');
    Route::get('/delete-purchase', [PurchaseController::class, 'deletePurchase'])->name('purchase.delete');

    //products
     Route::post('/update-product', [ProductController::class, 'updateProduct'])->name('product.update');
     Route::get('/delete-product', [ProductController::class, 'deleteProduct'])->name('product.delete');
     Route::get('/product-save-page', [ProductController::class, 'productSavePage'])->name('product.save.page');

     //category
    Route::post('/update-category', [CategoryController::class, 'updateCategory'])->name('category.update');
    Route::get('/delete-category', [CategoryController::class, 'deleteCategory'])->name('category.delete');
    Route::get('/category-save-page', [CategoryController::class, 'categorySavePage'])->name('category.save.page');
});
