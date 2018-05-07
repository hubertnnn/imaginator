<?php

namespace HubertNNN\Imaginator\Core;

use HubertNNN\Imaginator\Utilities\ClassUtils;

class ImaginatorFactory
{
    public static $keyGenerators = [
        'md5' => \HubertNNN\Imaginator\Core\KeyGenerators\Md5KeyGenerator::class,
        'sha1' => \HubertNNN\Imaginator\Core\KeyGenerators\Sha1KeyGenerator::class,
    ];

    public static $imageProviders = [
        'filesystem' => \HubertNNN\Imaginator\Distribution\Providers\FilesystemProvider::class,
    ];

    public static $entityProviders = [
        'imageProvidingEntity' => \HubertNNN\Imaginator\Provision\Providers\ImaginatorEntityProvider::class,
    ];

    public static $processors = [
        'jpg' => \HubertNNN\Imaginator\Distribution\Processors\JpegProcessor::class,
        'png' => \HubertNNN\Imaginator\Distribution\Processors\PngProcessor::class,
    ];



    public static function createKeyGenerator($name, $masterKey)
    {
        return ClassUtils::buildClass([$name, $masterKey], self::$keyGenerators);
    }

    public static function createImageProvider($name)
    {
        return ClassUtils::buildClass($name, self::$imageProviders);
    }

    public static function createProcessor($name)
    {
        return ClassUtils::buildClass($name, self::$processors);
    }

}
