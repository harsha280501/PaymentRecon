<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider {
    /**
     * Register services.
     */
    public function register(): void {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {

        // checks for a variable named ActiveTab
        Blade::directive('tab', function ($tab) {
            return "<?php if (\$activeTab === $tab): ?>";
        });
        // close tab
        Blade::directive('endtab', function () {
            return '<?php endif; ?>';
        });
    }
}