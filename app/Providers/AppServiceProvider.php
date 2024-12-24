<?php

namespace App\Providers;

use App\Services\GeneralService;
use App\Traits\HandlesDates;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;

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

        // if ($_SERVER['HTTP_HOST'] == "powerbi.abfrl.com") {
        //     URL::forceScheme('https');
        // }

        Paginator::useBootstrap();
        // share to all the view files
        View::share('config', GeneralService::appConfigData());


        Blade::directive('money', function ($amount) {
            return "<?php echo ' ' . number_format($amount, 2); ?>";
        });

        Blade::directive('withSymbolMoney', function ($amount) {
            return "<?php echo '₹ ' . number_format($amount, 2); ?>";
        });


    }
}
