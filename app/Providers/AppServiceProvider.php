<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; //  <-- เพิ่ม use statement
use App\Models\Order;                 //  <-- เพิ่ม use statement
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

/**
 * Bootstrap any application services.
 */
public function boot(): void
{
    // สร้าง View Composer สำหรับ admin.dashboard
    View::composer('admin.dashboard', function ($view) {
        $newOrdersCount = Order::where('order_status_id', 2)->count();
        $shippingOrdersCount = Order::where('order_status_id', 3)->count();
        $deliveredOrdersCount = Order::where('order_status_id', 5)->count();
        $canceledOrdersCount = Order::where('order_status_id', 4)->count();

        $view->with(compact(
            'newOrdersCount', 
            'shippingOrdersCount', 
            'deliveredOrdersCount', 
            'canceledOrdersCount' 
        ));
    });

    Paginator::useBootstrapFive();
}
}
