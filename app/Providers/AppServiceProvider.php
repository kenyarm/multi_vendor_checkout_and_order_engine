<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use App\Events\PaymentSucceeded;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

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
        Event::listen(
            OrderPlaced::class,
            'App\Listeners\SendOrderConfirmationEmail'
        );

        Event::listen(
            PaymentSucceeded::class,
            'App\Listeners\UpdateOrderStatus'
        );
    }
}
