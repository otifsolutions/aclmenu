<?php

namespace OTIFSolutions\ACLMenu;

use Illuminate\Support\ServiceProvider;

class ACLMenuServiceProvider extends ServiceProvider {
    
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'acl-menu');
        
        $this->app['router']->aliasMiddleware('role', Http\Middleware\UserRole::class);
        
        if ($this->app->runningInConsole()) {
        $this->commands([
            Commands\RefreshMenuPermissions::class,
        ]);
    }
    }
    
    public function register()
    {
        
    }
    
}

?>
