<?php

namespace App\Providers;

use App\Cart\DatabaseCart;
use App\Cart\SessionCart;
use App\Gateways\Zarrinpal;
use App\Interfaces\CartInterface;
use App\Interfaces\GatewayInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CartInterface::class, function ($app) {
            return auth()->check() ? new DatabaseCart() : new SessionCart();
        });

        $this->app->bind(GatewayInterface::class, function ($app) {
            if (request()->has('gateway_id')) {
                $gateway = array_values(array_filter(config('gateway'), function ($arr) {
                    return $arr['id'] == request()->get('gateway_id');
                }))[0];
                $gatewayClassName = $gateway['class'];
                $class = "\App\Gateways\\$gatewayClassName";
                return new $class();
            }
            return new Zarrinpal();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
