<?php

use App\Http\Controllers\Backend\CartController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SubcategoryController;
use App\Http\Controllers\Backend\InventoryController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\CustomerController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\Product;
use App\Http\Controllers\Frontend\StripePaymentController;
use App\Http\Controllers\SslCommerzPaymentController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [HomePageController::class, 'index'])->name('home.page');
Route::get('/me', [HomePageController::class, 'create'])->name('home.create');
Route::get('/com', [HomePageController::class, 'store'])->name('home.store');
Route::get('/email/{name}/{email}', [HomePageController::class, 'email'])->name('home.email');

Route::get('/product-details/{id}', [Product::class, 'index'])->name('product.index');
Route::post('/product/getsize', [Product::class, 'getsize']);

// Customer
Route::group(['prefix' => 'customer'], function () {
    Route::get('/register', [CustomerController::class, 'index'])->name('customer.register');
    Route::post('/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/login', [CustomerController::class, 'customer_login'])->name('customer.login');
    Route::get('/profile', [CustomerController::class, 'show'])->name('customer.profile')->middleware('checkCustomer');
    Route::get('/invoice/{id}', [CustomerController::class, 'invoice'])->name('invoice');
    Route::get('/logout', [CustomerController::class, 'logout'])->name('customer.logout');
    Route::post('/profile-update', [CustomerController::class, 'update'])->name('customer.profile_update')->middleware('checkCustomer');

    Route::get('/mail/{id}', [CustomerController::class, 'mail'])->name('customer.mail');


    // Customer Password reset
    Route::get('/password-reset', [CustomerController::class, 'password_reset'])->name('customer.password_reset');
    Route::post('/password-token-store', [CustomerController::class, 'token_store'])->name('customer.token_store');
    Route::get('/reset-password-change/{token}', [CustomerController::class, 'password_change'])->name('customer.password_change');
    Route::post('/password-store', [CustomerController::class, 'password_store'])->name('customer.password_store');


    // Customer Email Verify
    Route::get('/email-verify/{token}', [CustomerController::class, 'email_verify'])->name('email.verify');
});

// Cart
Route::group(['prefix' => 'cart'], function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/store', [CartController::class, 'store'])->name('cart.store');
    Route::get('/delete/{id}', [CartController::class, 'destroy'])->name('cart.delete');
    Route::post('/update', [CartController::class, 'update'])->name('cart.update');
});

// Checkout
Route::group(['prefix' => '/checkout'], function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/getcity', [CheckoutController::class, 'getcity']);
    Route::post('/order', [CheckoutController::class, 'order'])->name('checkout.order');
    Route::get('/confirm', [CheckoutController::class, 'confirm'])->name('checkout.confirm');
    Route::get('/success', [CheckoutController::class, 'success'])->name('checkout.success');
});


Auth::routes();


Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => '/dashboard'], function () {

        Route::get('/', [HomeController::class, 'dashboard'])->name('admin.dashboard');

        // Users
        Route::group(['prefix' => '/user'], function () {
            Route::get('/', [HomeController::class, 'index'])->name('user.manage');
            Route::get('/profile', [HomeController::class, 'profile'])->name('user.profile');
            Route::get('/edit/{id}', [HomeController::class, 'edit'])->name('user.edit');
            Route::post('/update', [HomeController::class, 'update'])->name('user.update');
            Route::get('/delete/{id}', [HomeController::class, 'delete'])->name('user.delete');
        });

        // Category
        Route::group(['prefix' => '/category'], function () {
            Route::get('/', [CategoryController::class, 'index'])->name('category');
            Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
            Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
            Route::post('/update', [CategoryController::class, 'update'])->name('category.update');
            Route::get('/restore/{id}', [CategoryController::class, 'restore'])->name('category.restore');
            Route::get('/forcedel/{id}', [CategoryController::class, 'forcedel'])->name('category.forcedel');
            Route::post('/alltrash', [CategoryController::class, 'alltrash'])->name('category.alltrash');
            Route::post('/allrestore', [CategoryController::class, 'allrestore'])->name('category.allrestore');
            Route::get('/perdelete', [CategoryController::class, 'perdelete'])->name('category.perdelete');

            Route::get('/download', [CategoryController::class, 'download'])->name('category.download');
        });

        // SubCategory
        Route::group(['prefix' => '/subcategory'], function () {
            Route::get('/', [SubcategoryController::class, 'index'])->name('subcategory.index');
            Route::post('/store', [SubcategoryController::class, 'store'])->name('subcategory.store');
            Route::get('/delete/{id}', [SubcategoryController::class, 'delete'])->name('subcategory.delete');
            Route::get('/edit/{id}', [SubcategoryController::class, 'edit'])->name('subcategory.edit');
            Route::post('/update', [SubcategoryController::class, 'update'])->name('subcategory.update');
        });

        // Product
        Route::group(['prefix' => '/product'], function () {
            Route::get('/', [ProductController::class, 'index'])->name('product.manage');
            Route::get('/create', [ProductController::class, 'create'])->name('product.create');
            Route::post('/store', [ProductController::class, 'store'])->name('product.store');
            Route::get('/view/{id}', [ProductController::class, 'show'])->name('product.show');
            Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
            Route::post('/update', [ProductController::class, 'update'])->name('product.update');
            Route::get('/delete/{id}', [ProductController::class, 'destroy'])->name('product.delete');

            Route::post('/subcategory', [ProductController::class, 'subcategory']);
            Route::get('/thumbnails/{id}', [ProductController::class, 'thumbnails']);
            Route::post('/delthumbnail', [ProductController::class, 'delthumbnail']);
        });

        // Inventory
        Route::group(['prefix' => '/inventory'], function () {
            Route::get('/manage/{id}', [InventoryController::class, 'index'])->name('inventory.manage');

            Route::post('/store', [InventoryController::class, 'store'])->name('inventory.store');

            Route::get('/color', [InventoryController::class, 'color'])->name('inventory.color');
            Route::post('/colorStore', [InventoryController::class, 'colorStore'])->name('inventory.colorStore');
            Route::get('/color_delete/{id}', [InventoryController::class, 'color_delete'])->name('inventory.color_delete');

            Route::get('/size', [InventoryController::class, 'size'])->name('inventory.size');
            Route::post('/sizeStore', [InventoryController::class, 'sizeStore'])->name('inventory.sizeStore');
            Route::get('/size_delete/{id}', [InventoryController::class, 'size_delete'])->name('inventory.size_delete');

            Route::get('/all-inventory', [InventoryController::class, 'show_all_inventory'])->name('inventory.all');
            Route::get('/create', [InventoryController::class, 'create'])->name('inventory.create');
            Route::get('/edit/{id}', [InventoryController::class, 'edit'])->name('inventory.edit');
            Route::post('/update', [InventoryController::class, 'update'])->name('inventory.update');
            Route::get('/delete/{id}', [InventoryController::class, 'destroy'])->name('inventory.delete');
        });

        // Coupon
        Route::group(['prefix' => '/coupon'], function () {
            Route::get('/', [CouponController::class, 'index'])->name('coupon.index');
            Route::post('/store', [CouponController::class, 'store'])->name('coupon.store');
            Route::get('/delete/{id}', [CouponController::class, 'destroy'])->name('coupon.delete');
            Route::get('/edit/{id}', [CouponController::class, 'edit'])->name('coupon.edit');
            Route::post('/update', [CouponController::class, 'update'])->name('coupon.update');
        });

    });
});

Route::get('/del', [HomePageController::class, 'delme']);


// SSLCOMMERZ Start
Route::get('/ssltotal', [SslCommerzPaymentController::class, 'exampleHostedCheckout'])->name('sslpay');

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END


//Stripe
Route::get('/stripe', [StripePaymentController::class, 'stripe'])->name('stripe.home');
Route::post('/stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post');

Route::get('/demo', [CustomerController::class, 'destroy']);


//Github
Route::get('/auth/github/redirect', [FacebookController::class, 'githubRedirect'])->name('github.redirect');
Route::get('/auth/github/callback', [FacebookController::class, 'githubCallback'])->name('github.callback');

//Google
Route::get('/auth/google/redirect', [FacebookController::class, 'googleRedirect'])->name('google.redirect');
Route::get('/auth/google/callback', [FacebookController::class, 'googleCallback'])->name('google.callback');


