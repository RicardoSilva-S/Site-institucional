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

        // @content('home.hero.title') imprime o texto editável dessa key
        // (override salvo pelo painel /admin/conteudo, ou o default de
        // config/site_content.php). Ver App\Support\SiteContent.
        Blade::directive('content', function ($expression) {
            return "<?php echo e(\App\Support\SiteContent::text({$expression})); ?>";
        });
    }
}
