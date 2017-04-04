<?php

namespace JoePriest\PasswordReset;

use Illuminate\Support\ServiceProvider;

class PasswordResetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/passwordreset.php' => config_path('passwordreset.php'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                PasswordResetCommand::class
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/passwordreset.php', 'passwordreset'
        );
    }
}
