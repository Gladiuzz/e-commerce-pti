<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DriverProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NameController;
use App\Http\Controllers\TransactionFeeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// for Cron Job
Route::get('/schedule', function () {
    Artisan::call('schedule:run');
    echo 'Schedule run success';
});

Route::get('/checkout', function () {
    return view('landing-page.checkout');
});
Route::get('/', [App\Http\Controllers\HomeController::class, 'indexUser']);
Route::get('/product-user/search/', [App\Http\Controllers\HomeController::class, 'searchProduct']);
Route::get('/product-user/{category}', [App\Http\Controllers\HomeController::class, 'productUser']);
Route::get('/product-user/{category}/{id}', [App\Http\Controllers\HomeController::class, 'showProductUser']);
Route::get('/cancel-deliver/{id}', [App\Http\Controllers\HomeController::class, 'cancelTransaction']);
Route::get('/received-product/{id}', [App\Http\Controllers\HomeController::class, 'productReceived']);
Route::get('/pendaftaran', [App\Http\Controllers\HomeController::class, 'pendaftaran']);
Route::get('/register-driver',[App\Http\Controllers\HomeController::class, 'registerDriver']);

// Cart
Route::post('/add-cart', [CartController::class, 'create'])->name('add.cart');
Route::delete('/delete-cart-product', [CartController::class, 'destroy'])->name('delete.cart.product');
// Profile costumer
Route::get('/profil-pelanggan', [CustomerController::class, 'showProfile'])->name('profil.pelanggan');
Route::get('/ubah-profil-pelanggan', [CustomerController::class, 'editProfile'])->name('ubah.profil.pelanggan');
Route::post('/simpan-profil-pelanggan', [CustomerController::class, 'updateProfile'])->name('simpan.profil.pelanggan');

// Checkout and History Transaction
Route::group(['middleware' => 'auth'], function () {
    Route::get('/order', [App\Http\Controllers\HomeController::class, 'showTransactionHistoryUser']);
    Route::get('/order-cancel/{id}', [TransactionController::class, 'cancelTransaction']);
    Route::get('/order/invoice/{id}', [HomeController::class, 'detailOrder']);

    Route::get('/transaction-history', [HomeController::class, 'showTransactioHistorynUser'])->name('history.transaction');
    Route::get('/checkout', [CheckOutController::class, 'index']);
    Route::post('/payment', [TransactionController::class, 'paymentSnap'])->name('payment');
});

// Courier
Route::get('/courier/{id}', [CourierController::class, 'costCourier'])->name('courier');
Route::get('/getcity/{id}', [CourierController::class, 'getCity'])->name('getcity');
Route::get('/getprovince', [CourierController::class, 'getProvince'])->name('getProvince');

Auth::routes();

Auth::routes(['verify' => true]);

Route::group(['middleware' => 'management'], function () {
    // Dashboard/home
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('home');

    // FEE
    Route::get('/fee', [App\Http\Controllers\TransactionFeeController::class, 'index'])->name('fee');

    // Product
    Route::group(['prefix' => 'product'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('product');
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::get('/delete/{id}', [ProductController::class, 'destroy'])->name('product.delete');
        Route::get('/show/{id}', [ProductController::class, 'show'])->name('product.show');
    });

    // User Update Status
    Route::post('users/update-status', [UserController::class, 'updateStatus'])->name('user.update-status');

    // User seller
    Route::group(['prefix' => 'user-seller'], function () {
        Route::get('/', [UserController::class, 'indexSeller'])->name('user.seller');
        Route::get('/create', [UserController::class, 'create'])->name('user.seller.create');
        Route::post('/store', [UserController::class, 'store'])->name('user.seller.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.seller.edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('user.seller.update');
        Route::get('/delete/{id}', [UserController::class, 'destroy'])->name('user.seller.delete');
        Route::get('/show/{id}', [UserController::class, 'show'])->name('user.seller.show');
    });

    Route::group(['prefix' => 'user-driver'], function () {
        Route::get('/', [UserController::class, 'indexDriver'])->name('user.driver');
        Route::get('/create', [UserController::class, 'create'])->name('user.driver.create');
        Route::post('/store', [UserController::class, 'store'])->name('user.driver.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.driver.edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('user.driver.update');
        Route::get('/delete/{id}', [UserController::class, 'destroy'])->name('user.driver.delete');
        Route::get('/show/{id}', [UserController::class, 'show'])->name('user.driver.show');
    });

    Route::group(['prefix' => 'driver-product'], function () {
        Route::get('/', [DriverProductController::class, 'index'])->name('driver');
        Route::get('/create', [DriverProductController::class, 'create'])->name('driver.create');
        Route::post('/store', [DriverProductController::class, 'store'])->name('driver.store');
        Route::get('/edit/{id}', [DriverProductController::class, 'edit'])->name('driver.edit');
        Route::post('/update/{id}', [DriverProductController::class, 'update'])->name('driver.update');
        Route::get('/delete/{id}', [DriverProductController::class, 'destroy'])->name('driver.delete');
        Route::get('/show/{id}', [DriverProductController::class, 'show'])->name('driver.show');
    });

    Route::group(['prefix' => 'contact'], function () {
        Route::get('/', [ContactController::class, 'index'])->name('contact');
        Route::get('/create', [ContactController::class, 'create'])->name('contact.create');
        Route::post('/store', [ContactController::class, 'store'])->name('contact.store');
        Route::get('/edit/{id}', [ContactController::class, 'edit'])->name('contact.edit');
        Route::post('/update/{id}', [ContactController::class, 'update'])->name('contact.update');
        Route::get('/delete/{id}', [ContactController::class, 'destroy'])->name('contact.delete');
        Route::get('/show/{id}', [ContactController::class, 'show'])->name('contact.show');
    });

    // User Customer
    Route::group(['prefix' => 'user-customer'], function () {
        Route::get('/', [UserController::class, 'indexCustomer'])->name('user.customer');
    });

    Route::group(['prefix' => 'monitoring'], function () {
        Route::get('/', [UserController::class, 'indexMonitoring'])->name('user.monitoring');
        Route::get('/{id}', [UserController::class, 'showMonitoring'])->name('show.monitoring');
    });

    // Category
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', [ProductCategoryController::class, 'index'])->name('category');
        Route::get('/create', [ProductCategoryController::class, 'create'])->name('category.create');
        Route::post('/store', [ProductCategoryController::class, 'store'])->name('category.store');
        Route::get('/edit/{id}', [ProductCategoryController::class, 'edit'])->name('category.edit');
        Route::post('/update/{id}', [ProductCategoryController::class, 'update'])->name('category.update');
        Route::get('/delete/{id}', [ProductCategoryController::class, 'destroy'])->name('category.delete');
        Route::get('/show/{id}', [ProductCategoryController::class, 'show'])->name('category.show');
    });

    Route::group(['prefix' => 'product-name'], function () {
        Route::get('/', [NameController::class, 'index'])->name('name');
        Route::get('/create', [NameController::class, 'create'])->name('name.create');
        Route::post('/store', [NameController::class, 'store'])->name('name.store');
        Route::get('/edit/{id}', [NameController::class, 'edit'])->name('name.edit');
        Route::post('/update/{id}', [NameController::class, 'update'])->name('name.update');
        Route::get('/delete/{id}', [NameController::class, 'destroy'])->name('name.delete');
        Route::get('/show/{id}', [NameController::class, 'show'])->name('name.show');
    });

    // transaction
    Route::group(['prefix' => 'transaction'], function () {
        Route::get('/', [TransactionController::class, 'index'])->name('transaction');
        Route::get('/{id}/request-cashout', [TransactionController::class, 'requestCashOut'])->name('transaction.request.cashout');
        Route::get('/get-all-cashout', [TransactionController::class, 'requestAllCashOut'])->name('request.all.cashout');
        Route::get('/accept-cashout/{id}', [TransactionController::class, 'acceptCashOut'])->name('accept.cash.out');
        Route::get('/get-amount/{id}', [TransactionController::class, 'transactionAmount']);
        // Route::get('/create', [TransactionController::class, 'create'])->name('transaction.create');
        // Route::post('/store', [TransactionController::class, 'store'])->name('transaction.store');
        // Route::get('/edit/{id}', [TransactionController::class, 'edit'])->name('transaction.edit');
        // Route::post('/update/{id}', [TransactionController::class, 'update'])->name('transaction.update');
        // Route::get('/delete/{id}', [TransactionController::class, 'destroy'])->name('category.delete');
        // Route::get('/show/{id}', [TransactionController::class, 'show'])->name('transaction.show');
    });

    // order
    Route::group(['prefix' => 'order'], function () {
        Route::get('/processing', [OrderController::class, 'index'])->name('order.pending');
        Route::get('/cancelled', [OrderController::class, 'index'])->name('order.cancelled');
        Route::get('/delivered', [OrderController::class, 'index'])->name('order.delivered');
        Route::get('/success', [OrderController::class, 'index'])->name('order.success');
        Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
        Route::post('/update/{id}', [OrderController::class, 'update'])->name('order.update');
        Route::get('/generate', [OrderController::class, 'generate'])->name('order.generate');
    });
});
