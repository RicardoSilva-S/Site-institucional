<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // diretiva @vite para o laravel 8
        Blade::directive('vite', function ($entradas) {
            return "<?php echo \\App\\Support\\Vite::tags({$entradas}); ?>";
        });
    }
}
