<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\TackbackStoreController;
use App\Http\Controllers\Auth\LoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('admin/newdashboard', function () {
    echo "hello";
    // Logic for admin dashboard...
})->middleware('role:admin');

Route::middleware(['auth'])->group(function () {
    // Define your admin routes here

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/admin/tackback', [AdminController::class, 'tackbackList'])->name('admin.tackbacklist');

    Route::post('/admin/brands/save', [BrandController::class, 'store'])->name('brand.store');

    Route::post('/admin/tackback-product/save', [AdminController::class, 'store'])->name('trackbackProduct.store');

    Route::post('/admin/tackback-product/update', [TackbackStoreController::class, 'updateStores'])->name('trackbackProduct.update.stores');

    Route::post('/admin/tackback-product-save-and-open/update', [TackbackStoreController::class, 'updateSaveAndOpenStores'])->name('trackbackProductSaveAndOpen.update.stores');

    Route::get('/admin/brands/create', [BrandController::class, 'create'])->name('brands.create');
    // Add more admin routes as needed

    // store routes
    Route::get('/admin/tackback-store/create', [TackbackStoreController::class, 'create'])->name('admin.stores.create');

    Route::post('/admin/tackback-store/save', [TackbackStoreController::class, 'store'])->name('tackback.store');

    Route::get('/admin/tackback-store/detail', [TackbackStoreController::class, 'index'])->name('admin.stores.index');

    Route::get('/admin/tackback-store/save-list', [TackbackStoreController::class, 'tackbackStoreSaveList'])->name('admin.stores.saveList');

    Route::get('/admin/tackback-store/clear', [TackbackStoreController::class, 'cancelForm'])->name('tackback.stores.cancel');

    Route::get('/admin/tackback-store/brands', [TackbackStoreController::class, 'filterBrands'])->name('admin.stores.brand-filter');

    Route::get('/admin/tackback-store/search', [TackbackStoreController::class, 'searchStore'])->name('admin.stores.search-store');

    Route::get('/admin/tackback-store/shipment-detail', [TackbackStoreController::class, 'shipmentDetail'])->name('admin.stores.shipment-detail');

    Route::get('/admin/tackback-store/pallet-detail', [TackbackStoreController::class, 'palletDetail'])->name('admin.stores.pallet-detail');

    Route::post('/admin/tackback-store/create-boxes', [TackbackStoreController::class, 'createBoxes'])->name('tackbackStore.box.creates');

    Route::get('/admin/tackback-store/pallet-boxes-detail', [TackbackStoreController::class, 'palletBoxesDetail'])->name('tackbackStore.box.palllet-detail');

    Route::post('/admin/tackback-store/save-new-boxes', [TackbackStoreController::class, 'saveNewBoxes'])->name('tackbackStore.box.save');

    Route::delete('/admin/tackback-store/delete-new-boxes/{id}', [TackbackStoreController::class, 'deleteBox'])->name('tackbackStore.box.delete');

    Route::get('/admin/tackback-store/pallet-boxes-product-list', [TackbackStoreController::class, 'palletBoxesProductList'])->name('tackbackStore.box.product-list');

    Route::post('/admin/tackback-store/save-boxes-new-product', [TackbackStoreController::class, 'saveBoxNewProduct'])->name('tackbackStore.box.product.save');

    Route::post('/admin/tackback-store/updated-new-boxes', [TackbackStoreController::class, 'updateNewBoxes'])->name('tackbackStore.box.updated');

    Route::get('/admin/tackback-store/create-store', [TackbackStoreController::class, 'createStore'])->name('admin.stores.create-store');

});


