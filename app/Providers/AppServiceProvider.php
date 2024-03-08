<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
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
        Blade::directive('authusercan', function ($expression) {
            return "<?php if (Auth::check() && Auth::user()->id == $expression) : ?>";
        });

        Blade::directive('elseauthusercan', function ($expression) {
            return "<?php else: ?>";
        });

        Blade::directive('endauthusercan', function ($expression) {
            return "<?php endif; ?>";
        });
    }
}
