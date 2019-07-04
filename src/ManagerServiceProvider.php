<?php
/**
 * Created by PhpStorm.
 * User: miliv
 * Date: 6/18/2019
 * Time: 4:04 PM
 */

namespace ItVision\ModManager;

use Illuminate\Support\ServiceProvider;

class ManagerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/database');
        $this->loadViewsFrom(__DIR__ . '/views', 'modManager');
    }


    public function register()
    {

    }
}
