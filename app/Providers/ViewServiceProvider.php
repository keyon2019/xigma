<?php

namespace App\Providers;

use App\Http\View\Composers\HeaderComposer;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('website.partials._header', function ($view) {
            return $view->with('categories', Category::take(4)->get());
        });
    }
}
