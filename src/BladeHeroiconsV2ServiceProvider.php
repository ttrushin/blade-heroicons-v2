<?php

declare(strict_types=1);

namespace BladeUI\HeroiconsV2;

use BladeUI\Icons\Factory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

final class BladeHeroiconsV2ServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('blade-heroicons-v2', []);

            $factory->add('heroicons2', array_merge(['path' => __DIR__.'/../resources/svg'], $config));
        });
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blade-heroicons-v2.php', 'blade-heroicons-v2');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/svg' => public_path('vendor/blade-heroicons-v2'),
            ], 'blade-heroicons-v2');

            $this->publishes([
                __DIR__.'/../config/blade-heroicons-v2.php' => $this->app->configPath('blade-heroicons-v2.php'),
            ], 'blade-heroicons-v2-config');
        }
    }
}
