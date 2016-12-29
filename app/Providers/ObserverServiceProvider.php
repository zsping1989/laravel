<?php

namespace App\Providers;

use App\Models\Menu;
use App\Observers\MenuObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Menu::observe(MenuObserver::class); //菜单目录监听
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {


    }


}
