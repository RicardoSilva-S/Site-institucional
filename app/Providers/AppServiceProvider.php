<?php

namespace App\Providers;

use App\Models\Banner;

use App\Support\SiteContent;

use Illuminate\Support\Facades\Blade;

use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\View;

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

        // @content('home.hero.title') imprime o texto atual dessa key
        // (tabela site_texts, editada pelo painel /adm). Ver App\Support\SiteContent.
        
        Blade::directive('content', function ($expression) {
            return "<?php echo e(\App\Support\SiteContent::text({$expression})); ?>";
        });

        // @extraTexts('home.hero') imprime os textos que foram INCLUÍDOS pelo

        // painel nessa seção. Não imprime nada se não houver nenhum.

        Blade::directive('extraTexts', function ($expression) {

            return "<?php \$__extras = \App\Support\SiteContent::extras({$expression}); if (\$__extras): ?>"

                .'<div class="extra-texts">'

                ."<?php foreach (\$__extras as \$__extra): ?><p><?php echo nl2br(e(\$__extra)); ?></p><?php endforeach; ?>"

                .'</div><?php endif; ?>';

        });

        // Banners ativos da página atual (ou marcados para "todas as páginas"),
        // usados por resources/views/partials/banner.blade.php.
        View::composer('partials.banner', function ($view) {
            $banners = collect();
 
            if (Schema::hasTable('banners')) {
                $route = optional(request()->route())->getName();
 
                $banners = Banner::query()
                    ->select(Banner::LIST_COLUMNS)
                    ->where('active', true)
                    ->where(function ($q) use ($route) {
                        $q->where('page', $route)->orWhereNull('page');
                    })
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->get();
            }
 
            $view->with('banners', $banners);
        });

        // Menu lateral do painel: uma entrada por página do config.

        View::composer('layouts.admin', function ($view) {

            $view->with('adminPages', SiteContent::schema());

        });

    }

}
