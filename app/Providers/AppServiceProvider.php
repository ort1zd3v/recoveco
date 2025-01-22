<?php

namespace App\Providers;

use App\Http\Controllers\MainmenuController;
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
        view()->composer('components.theme.sidebar', function($view) {
			$menuController = new MainmenuController();
			$view->with('menus', $menuController->getMenus());
		});
    }
}
