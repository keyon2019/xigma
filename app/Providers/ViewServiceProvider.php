<?php

namespace App\Providers;

use App\Http\View\Composers\HeaderComposer;
use App\Models\Category;
use App\Models\Order;
use App\Models\Page;
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
            $pages = Page::root()->select('slug', 'name', 'position', 'link')->get();
            return $view->with([
                'categories' => Category::root()->visible()->with('subCategories')->get(),
                'pages' => $pages->filter(function ($value) {
                    return $value->position === 1 || $value->position === 5;
                })
            ]);
        });

        View::composer('website.partials._footer', function ($view) {
            $pages = Page::select('slug', 'name', 'position', 'link')->get();
            return $view->with('pages', $pages->filter(function ($value) {
                return $value->position > 1;
            }));
        });
    }
}
