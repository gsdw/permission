<?php
namespace Gsdw\Permission\Providers;

use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(DIR_GSDW_PERMISSION.'/views', 'gsdw_permission');
        $this->publishes([
            DIR_GSDW_PERMISSION.'/views' => 
                base_path('resources/views/vendor/gsdw/permission'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/../routes.php';
    }
}
