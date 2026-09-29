<?php

namespace App\Providers;

use Illuminate\Auth\Middleware\Authenticate;
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
        // @content('home.hero.title') imprime o texto editável dessa key
        // (override salvo pelo painel /admin/conteudo, ou o default de
        // config/site_content.php). Ver App\Support\SiteContent.
        Blade::directive('content', function ($expression) {
            return "<?php echo e(\App\Support\SiteContent::text({$expression})); ?>";
        });

        // Quem tentar abrir uma rota protegida (ex: /admin/conteudo) sem
        // estar logado é mandado para a tela de login, em vez de levar 401.
        Authenticate::redirectUsing(fn () => route('login'));
    }
}
