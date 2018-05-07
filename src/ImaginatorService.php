<?php

namespace HubertNNN\Imaginator;

use HubertNNN\Imaginator\Contracts\EntityImageProvider;
use HubertNNN\Imaginator\Contracts\ImageDistributor;
use HubertNNN\Imaginator\Contracts\ImageStorage;
use HubertNNN\Imaginator\Contracts\ImageUrlGenerator;
use HubertNNN\Imaginator\Contracts\ImaginatorSystem;
use HubertNNN\Imaginator\Contracts\KeyGenerator;
use HubertNNN\Imaginator\Services\ImageFormatService;
use HubertNNN\Imaginator\Services\ImageProcessorService;

class ImaginatorService implements ImaginatorSystem
{
    /** @var KeyGenerator */
    protected $keyGenerator;

    /** @var EntityImageProvider */
    protected $imageProvider;

    /** @var ImageFormatService */
    protected $imageFormats;

    /** @var ImageProcessorService */
    protected $imageProcessors;

    /** @var ImageStorage */
    protected $imageCache;

    /** @var ImageDistributor */
    protected $imageDistributor;

    /** @var ImageUrlGenerator */
    protected $imageUrlGenerator;

    public function __construct($imageProviderService, $imageCacheService, $imageFormatsService, $imageProcessors, $imageDistributor, $keyGenerator, $imageUrlGenerator)
    {
        $this->imageProvider = $imageProviderService;
        $this->imageCache = $imageCacheService;
        $this->imageFormats = $imageFormatsService;
        $this->imageProcessors = $imageProcessors;
        $this->imageDistributor = $imageDistributor;
        $this->keyGenerator = $keyGenerator;
        $this->imageUrlGenerator = $imageUrlGenerator;
    }

    public function generateKey($type, $instance, $format)
    {
        $extension = $this->getExtension($type, $format);

        return $this->keyGenerator->generateKey($type, $instance, $format, $extension);
    }

    public function validateKey($type, $instance, $format, $extension, $key)
    {
        $validKey = $this->keyGenerator->generateKey($type, $instance, $format, $extension);

        return $key == $validKey;
    }

    public function getExtension($type, $format)
    {
        $config = $this->imageFormats->getConfig($type, $format);
        if($config === null)
            return null;

        $processor = $this->imageProcessors->getProcessor($config['processor']);
        if($processor === null)
            return null;

        return $processor->getExtension();
    }

    public function getImage($type, $instance)
    {
        return $this->imageProvider->getImage($type, $instance);
    }

    public function process($source, $target, $type, $format)
    {
        $config = $this->imageFormats->getConfig($type, $format);
        if($config === null)
            return null;

        $processor = $this->imageProcessors->getProcessor($config['type']);
        if($processor === null)
            return null;

        return $processor->process($source, $target, $config);
    }


    public function send($image)
    {
        return $this->imageDistributor->send($image);
    }

    public function sendLater()
    {
        return $this->imageDistributor->sendLater();
    }

    public function sendError()
    {
        return $this->imageDistributor->sendError();
    }

    public function getCachedImage($type, $instance, $format, $extension)
    {
        return $this->imageCache->getFileLocation($type, $instance, $format, $extension);
    }

    // Provider api
    // -----------------------------------------------------------------------------------------------------------------
    // Public api

    public function entity($entity, $format, $type)
    {
        $result = $this->imageProvider->getTypeAndInstance($entity, $type);
        if($result === null)
            return null;

        list($imageType, $instance) = $result;
        return $this->image($imageType, $instance, $format);
    }

    public function image($type, $instance, $format)
    {
        if(!$this->imageFormats->hasConfig($type, $format))
            return null;

        $key = $this->generateKey($type, $instance, $format);
        $extension = $this->getExtension($type, $format);

        return $this->imageUrlGenerator->buildUrl($type, $instance, $format, $key, $extension);
    }



    public function test()
    {
        dump('testing');
    }
}
