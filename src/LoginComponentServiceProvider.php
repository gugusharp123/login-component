<?php

namespace Avalon\LrvLogin;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Avalon\LrvLogin\Observers\UserObserver;
use App\Models\User;

class LoginComponentServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        // Merge package configuration with app's configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/custom_login.php', 'custom_login');
    }

    public function boot()
    {
        User::observe(UserObserver::class);
        // Create custom_login file in main app's config folder
        if (!file_exists(config_path('custom_login.php'))) {
            copy(__DIR__ . '/../config/custom_login.php', config_path('custom_login.php'));
        }
        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'lrv_login');
        // Load lang file
        $this->loadJsonTranslationsFrom(__DIR__.'/../resources/lang', 'lrv_login');
    }
}
