<?php

namespace State\S3SignedRoute;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class S3SignedRouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        Route::macro('signedS3Route', function(string $route = 's3-signed-route') {
            return Route::post($route, CreateSignedRouteAction::class)->name('s3-signed-route');
        });
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/s3_signed_route.php', 's3_signed_route');
    }

    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/s3_signed_route.php' => config_path('s3_signed_route.php'),
        ], 's3_signed_route.config');
    }
}
