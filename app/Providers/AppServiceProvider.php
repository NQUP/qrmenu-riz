<?php

namespace App\Providers;

use App\Http\View\Composers\HeaderComposer;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\SiteSetting;
use App\Observers\ProductCategoryObserver;
use App\Observers\ProductObserver;
use Illuminate\Support\Facades\View as ViewFacade;
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
        // Register model observers.
        Product::observe(ProductObserver::class);
        ProductCategory::observe(ProductCategoryObserver::class);

        // Make site settings available globally in Blade views.
        ViewFacade::composer('*', function ($view) {
            $siteSettings = SiteSetting::getCached();
            $view->with('siteSettings', $siteSettings);
        });

        // Provide categories to the site header composer.
        ViewFacade::composer('site.layouts.header', HeaderComposer::class);
    }
}
