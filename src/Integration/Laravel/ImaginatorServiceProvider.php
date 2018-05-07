<?php

namespace HubertNNN\Imaginator\Integration\Laravel;

use HubertNNN\Imaginator\Contracts\Imaginator;
use HubertNNN\Imaginator\KeyGenerators\Md5KeyGenerator;
use HubertNNN\Imaginator\Services\ImageFormatService;
use HubertNNN\Imaginator\Services\ImageProcessorService;
use HubertNNN\Imaginator\Services\ImageProviderService;
use HubertNNN\Imaginator\Storage\FileStorage;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class ImaginatorServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config.php', 'imaginator'
        );

        $this->app->singleton(Imaginator::class, function ($app) {

            /** @var Application $app */
            /** @var Repository $config */
            $config = $app['config'];

            $imageProviders = $config->get('imaginator.providers');
            $imageProviders = $this->buildClasses($imageProviders);
            $imageProviderService = new ImageProviderService($imageProviders);

            $imageCacheLocation = $config->get('imaginator.cache');
            $imageCache = new FileStorage($imageCacheLocation);

            $imageFormats = $config->get('imaginator.formats');
            $imageFormatsService = new ImageFormatService($imageFormats);

            $imageProcessors = $config->get('imaginator.processors');
            $imageProcessors = $this->buildClasses($imageProcessors);
            $imageProcessors = new ImageProcessorService($imageProcessors);

            $imageDistributor = new LaravelDistributor();

            $keyGenerator = $config->get('imaginator.security.keyGenerator');
            $masterKey = $config->get('imaginator.security.masterKey');
            $keyGenerator = new $keyGenerator($masterKey);

            return new ImaginatorService(
                $imageProviderService,
                $imageCache,
                $imageFormatsService,
                $imageProcessors,
                $imageDistributor,
                $keyGenerator);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config.php' => config_path('imaginator.php')
        ], 'config');
    }

    protected function buildClasses($definitions)
    {
        $result = [];

        foreach ($definitions as $key => $value) {
            $result[$key] = $this->buildClass($value);
        }

        return $result;
    }

    protected function buildClass($definition)
    {
        if(is_string($definition)) {
            return new $definition();
        }

        if(is_array($definition)) {
            $class = array_shift($definition);
            return new $class(...$definition);
        }

        if(is_object($definition)) {
            return $definition;
        }

        throw new \Exception('Definition cannot be resolved');
    }
}
