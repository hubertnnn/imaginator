<?php

namespace HubertNNN\Imaginator\Integration\Laravel;

use HubertNNN\Imaginator\Contracts\Distribution;
use HubertNNN\Imaginator\Contracts\Provision;
use HubertNNN\Imaginator\Core\ImaginatorFactory;
use HubertNNN\Imaginator\Core\Services\ImageFormatService;
use HubertNNN\Imaginator\Distribution\ImaginatorDistributionService;
use HubertNNN\Imaginator\Distribution\Services\ImageProcessorService;
use HubertNNN\Imaginator\Distribution\Services\ImageProviderService;
use HubertNNN\Imaginator\Distribution\Storage\FileStorage;
use HubertNNN\Imaginator\Services\MultiProviderService;
use HubertNNN\Imaginator\Utilities\ClassUtils;
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

        $this->app->singleton(Provision\Imaginator::class, function ($app) {

            /** @var Application $app */
            /** @var Repository $config */
            $config = $app['config'];

            $masterKey = $config->get('imaginator.security.masterKey');
            $keyGenerator = $config->get('imaginator.security.keyGenerator');
            $keyGenerator = ImaginatorFactory::createKeyGenerator($keyGenerator, $masterKey);

            $imageFormats = $config->get('imaginator.formats');
            $imageFormats = new ImageFormatService($imageFormats);

            $imageProcessors = $config->get('imaginator.processors');
            $imageProcessors = ClassUtils::buildClasses($imageProcessors, ImaginatorFactory::$processors);
            $imageProcessors = new ImageProcessorService($imageProcessors);

            $imageProviders = $config->get('imaginator.entity_providers');
            $imageProviders = ClassUtils::buildClasses($imageProviders, ImaginatorFactory::$entityProviders);
            $imageProviders = new MultiProviderService($imageProviders);

            $imageUrlGenerator = new LaravelUrlGenerator();

            return new ImaginatorLaravelService(
                $keyGenerator,
                $imageFormats,
                $imageProcessors,
                $imageProviders,
                $imageUrlGenerator);
        });

        $this->app->singleton(Distribution\Imaginator::class, function ($app) {

            /** @var Application $app */
            /** @var Repository $config */
            $config = $app['config'];

            $masterKey = $config->get('imaginator.security.masterKey');
            $keyGenerator = $config->get('imaginator.security.keyGenerator');
            $keyGenerator = ImaginatorFactory::createKeyGenerator($keyGenerator, $masterKey);

            $imageFormats = $config->get('imaginator.formats');
            $imageFormats = new ImageFormatService($imageFormats);

            $imageProcessors = $config->get('imaginator.processors');
            $imageProcessors = ClassUtils::buildClasses($imageProcessors, ImaginatorFactory::$processors);
            $imageProcessors = new ImageProcessorService($imageProcessors);

            $imageProviders = $config->get('imaginator.providers');
            $imageProviders = ClassUtils::buildClasses($imageProviders, ImaginatorFactory::$imageProviders);
            $imageProviders = new ImageProviderService($imageProviders);

            $imageCache = $config->get('imaginator.cache');
            $imageCache = new FileStorage($imageCache);

            $imageDistributor = new LaravelDistributor();

            return new ImaginatorDistributionService(
                $keyGenerator,
                $imageFormats,
                $imageProcessors,
                $imageProviders,
                $imageCache,
                $imageDistributor);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config.php' => config_path('imaginator.php')
        ], 'config');
    }
}
