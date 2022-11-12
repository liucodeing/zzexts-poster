<?php

namespace Zzexts\Poster;

use Illuminate\Console\Command;
use Illuminate\Support\ServiceProvider;

class PosterServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(Poster $extension)
    {
        if (! Poster::boot()) {
            return ;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'poster');
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes([$assets => public_path('vendor/zzexts/poster')], 'poster');
            $this->publishes([__DIR__.'/../config' => config_path()], 'zzexts-poster-config');
        }

        $this->app->booted(function () {
            Poster::routes(__DIR__.'/../routes/web.php');
        });


    }
}
