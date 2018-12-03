<?php

namespace BoomDraw\Helpers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->isLaravel() && $this->app->runningInConsole()) {
            $this->publishes([
                $this->getConfigFile() => config_path('helpers.php'),
            ], 'config');
        }

        $finder = new HelpersFinder();
        $this->registerHelpers($finder->getHelpers());

    }

    /**
     * Register services.
     *
     * @throws \Exception
     */
    public function register()
    {
        $this->mergeConfigFrom(
            $this->getConfigFile(),
            'helpers'
        );

        $this->commands([
            Console\CacheAllCommand::class,
            Console\CacheClearAllCommand::class,
            Console\HelpersCacheCommand::class,
            Console\HelpersClearCommand::class,
            Console\IdeHelperAllCommand::class,
            Console\MakeHelperCommand::class
        ]);
    }

    private function registerHelpers(array $helpers)
    {
        foreach ($helpers as $helper) {
            $this->app->bind($helper['service'], $helper['class']);
            $loader = AliasLoader::getInstance();
            $loader->alias($helper['alias'], $helper['facade']);
        }
    }

    protected function isLaravel(): bool
    {
        return !preg_match('/lumen/i', app()->version());
    }

    protected function getConfigFile(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'helpers.php';
    }
}
