<?php

namespace BoomDraw\Helpers;

use Cache;
use Illuminate\Filesystem\Filesystem;
use BoomDraw\Helpers\Traits\ServiceNameGetter;
use Illuminate\Console\DetectsApplicationNamespace;

class HelpersFinder
{
    use ServiceNameGetter, DetectsApplicationNamespace;

    /**
     * @return array
     */
    private function getPackageHelpers(): array
    {
        return $this->helpers($this->packageHelpersPath(), $this->packageHelpersNamespace(), 'Facades');
    }

    /**
     * @return array
     */
    private function getCustomHelpers(): array
    {
        return $this->helpers(app_path(config('helpers.path')), $this->customHelpersNamespace(), config('helpers.facade_dir'));
    }

    /**
     * @return array
     */
    public function getHelpers(): array
    {
        if (empty($helpers = Cache::get(config('helpers.cache_key')))) {
            $helpers = array_merge($this->getCustomHelpers(), $this->getPackageHelpers());
            if (config('helpers.force_cache')) {
                Cache::forever(config('helpers.cache_key'), $helpers);
            }
        }

        return $helpers;
    }

    public function cacheHelpers()
    {
        Cache::forever(config('helpers.cache_key'), $this->getCustomHelpers() + $this->getPackageHelpers());
    }

    public function clearHelpers()
    {
        Cache::forget(config('helpers.cache_key'));
    }

    /**
     * @param string $path
     * @param string $namespace
     * @param string|null $facade_dir
     * @return array
     */
    private function helpers(string $path, string $namespace, ?string $facade_dir = null): array
    {
        $helpers = [];
        $filesystem = new Filesystem;
        if (!empty($facade_dir)) {
            $path = $path . DIRECTORY_SEPARATOR . $facade_dir;
            $facadeNamespace = $namespace . $facade_dir . '\\';
        } else {
            $facadeNamespace = $namespace;
        }
        if ($filesystem->exists($path)) {
            foreach ($filesystem->files($path) as $file) {
                $filename = pathinfo($file->getFilename(), PATHINFO_FILENAME);
                $classname = str_before($filename, 'Facade');
                if (
                    (!empty($facade_dir) || ends_with($filename, 'Facade'))
                    && class_exists($facade = $facadeNamespace . $filename)
                    && class_exists($class = ($namespace . $classname))
                ) {
                    $service = $this->getServiceName(snake_case($filename));
                    $alias = ends_with($classname, 'Helper') ? $classname : $classname . 'Helper';
                    $helpers[] = compact('service', 'alias', 'facade', 'class');
                }
            }
        }

        return $helpers;
    }

    /**
     * @return string
     */
    private function packageHelpersPath(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'Helpers';
    }

    /**
     * @return string
     */
    private function customHelpersNamespace(): string
    {
        return $this->getAppNamespace() . config('helpers.path') . '\\';
    }

    /**
     * @return string
     */
    private function packageHelpersNamespace(): string
    {
        return __NAMESPACE__ . '\Helpers\\';
    }
}
