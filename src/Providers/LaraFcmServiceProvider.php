<?php

namespace Waheed\LaravelFcmPushNotifications\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\ChannelManager;
use Waheed\LaravelFcmPushNotifications\Channels\FcmChannel;
use Waheed\LaravelFcmPushNotifications\Facades\LaraFcm;

class LaraFcmServiceProvider extends ServiceProvider
{
    /**
     * Register FCM Service
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register()
    {
        $serviceContainer = $this->app;

        $this->app->make(ChannelManager::class)->extend('firebase', function () use ($serviceContainer) {
            return $this->app->make(FcmChannel::class);
        });

        $this->mergeConfigFrom(
            __DIR__ . '../../Config/larafcm.php',
            'larafcm'
        );
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__. '/../Config/larafcm.php' => config_path('larafcm.php'),
        ]);

        $this->app->bind('larafcm', LaraFcm::class);
    }
}
