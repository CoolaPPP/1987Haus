<?php

use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;

use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\AddressController;
use App\Http\Controllers\Customer\OrderConfirmController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\OrderCancelController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfileController;

use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductTypeController;  
use App\Http\Controllers\Admin\RecommendProductController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CustomerAddressController;
use App\Http\Controllers\Admin\OrderStatusController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\OrderCancelController as AdminOrderCancelController;
use App\Http\Controllers\Admin\CanceledOrderController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\MainpageController;

Route::get('/', function () {
    return view('main');
});

// About Us
Route::get('/about-us', [AboutUsController::class, 'about'])->name('about-us');

//Products
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/recommended-products', [ShopController::class, 'recommended'])->name('shop.recommended');

//Guest 
Route::middleware('guest')->group(function () {
    //Register
    Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [CustomerAuthController::class, 'register']);

    //Login
    Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [CustomerAuthController::class, 'login']);

});

//User Login 
Route::middleware('auth')->group(function () {
    //Logout
    Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
    
    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('customer.dashboard');

    //Profile
    Route::get('/profile', [CustomerProfileController::class, 'edit'])->name('customer.profile.edit');
    Route::put('/profile', [CustomerProfileController::class, 'update'])->name('customer.profile.update');

    // Address 
    Route::get('/addresses/create', [AddressController::class, 'create'])->name('addresses.create');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('/addresses/{address}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');

    // Cart
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/apply-promo', [CartController::class, 'applyPromo'])->name('cart.apply-promo');

    //Checkout
    Route::get('/checkout/address', [CheckoutController::class, 'addressForm'])->name('checkout.address');
    Route::post('/checkout/address', [CheckoutController::class, 'storeAddress'])->name('checkout.store-address');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place-order');
    Route::get('/order/complete/{order}', [CheckoutController::class, 'complete'])->name('order.complete');

    //Payment
    Route::get('/payment/{order}', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment/{order}', [PaymentController::class, 'store'])->name('payment.store');

    // Order Confirmation
    Route::get('/confirm-receipt/{order}', [OrderConfirmController::class, 'create'])->name('order-confirm.create');
    Route::post('/confirm-receipt/{order}', [OrderConfirmController::class, 'store'])->name('order-confirm.store');

    // Recipt
    Route::get('/my-orders/{order}/receipt', [CustomerOrderController::class, 'showReceipt'])->name('customer.orders.receipt');

    //Cancel Order
    Route::get('/cancel-order', [OrderCancelController::class, 'selectOrder'])->name('order-cancel.select');
    Route::post('/cancel-order/confirm', [OrderCancelController::class, 'confirm'])->name('order-cancel.confirm');
    Route::delete('/cancel-order/{order}', [OrderCancelController::class, 'destroy'])->name('order-cancel.destroy');
});

// Admin Routes
Route::prefix('admin')->group(function () {
        //Admin Non-Login
        Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
    });

        //Admin Logged In
        Route::get('/home', [MainpageController::class, 'index'])->name('admin.main.index');

        // Routes Admin Login 
        Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
        
        // Admin Profile
        Route::get('/profile', [ProfileController::class, 'show'])->name('admin.profile.show');      
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');  
        Route::put('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');

        // Admin Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Product Types 
        Route::get('/product-types', [ProductTypeController::class, 'index'])->name('admin.product-types.index');
        Route::post('/product-types', [ProductTypeController::class, 'store'])->name('admin.product-types.store');
        Route::get('/product-types/{id}/edit', [ProductTypeController::class, 'edit'])->name('admin.product-types.edit'); 
        Route::put('/product-types/{id}', [ProductTypeController::class, 'update'])->name('admin.product-types.update'); 
        Route::delete('/product-types/{id}', [ProductTypeController::class, 'destroy'])->name('admin.product-types.destroy');

        // Products 
        Route::resource('products', ProductController::class)->names('admin.products');
        
        // Recommended Products
        Route::resource('recommend-products', RecommendProductController::class)
        ->except(['show']) 
        ->names('admin.recommend-products');

        //Promotions
        Route::resource('promotions', PromotionController::class)
        ->except(['show'])
        ->names('admin.promotions');    

        //Customer Data
        Route::get('/customers', [CustomerController::class, 'index'])->name('admin.customers.index');
        Route::get('/shipping-addresses', [CustomerAddressController::class, 'index'])->name('admin.shipping-addresses.index');

        // Order Statuses
        Route::resource('order-statuses', OrderStatusController::class)
        ->except(['show'])
        ->names('admin.order-statuses');

        //Order
        Route::get('/orders/new', [OrderController::class, 'index'])->name('admin.orders.new');
        Route::get('/orders/shipping', [OrderController::class, 'shipping'])->name('admin.orders.shipping');
        Route::get('/orders/delivered', [AdminOrderController::class, 'delivered'])->name('admin.orders.delivered');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
        Route::put('/orders/{order}/prepare', [AdminOrderController::class, 'prepare'])->name('admin.orders.prepare');

        //Receipt
        Route::get('/orders/{order}/receipt', [OrderController::class, 'showReceipt'])->name('admin.orders.receipt');
        Route::put('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');

        //Show Payment
        Route::get('/payments', [AdminPaymentController::class, 'index'])->name('admin.payments.index');
        
        //Show Order Delivered
        Route::get('/order-confirmations', [OrderController::class, 'confirmations'])->name('admin.order-confirmations.index');

        //Order Cancel
        Route::get('/order-cancels', [AdminOrderCancelController::class, 'index'])->name('admin.order-cancels.index'); 
        Route::get('/order-cancels/{orderCancel}', [AdminOrderCancelController::class, 'show'])->name('admin.order-cancels.show'); 

        //Order Canceled
        Route::get('/canceled-orders', [CanceledOrderController::class, 'index'])->name('admin.canceled-orders.index');

        //Reports
        Route::get('/reports/sales', [AdminReportController::class, 'sales'])->name('admin.reports.sales');
        Route::get('/reports/top-products', [AdminReportController::class, 'topProducts'])->name('admin.reports.top-products');
    });
});

Route::get('/test-time', function () {
    // ดึง Order ล่าสุดออกมา
    $latestOrder = \App\Models\Order::latest('order_datetime')->first();

    if ($latestOrder) {
        // dd() จะแสดงผล Carbon object ซึ่งจะบอก Timezone ที่ถูกต้อง
        dd($latestOrder->order_datetime);
    }

    return 'No orders found.';
});
Route::get('/check-time', function () {
    // dd() จะหยุดการทำงานและแสดงผลค่าที่เราต้องการดู
    dd(
        'Config Timezone:', 
        config('app.timezone'), 
        'Current App Time:', 
        now()
    );
});