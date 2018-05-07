<?php

namespace HubertNNN\Imaginator\Core;

use HubertNNN\Imaginator\Contracts\Distribution\KeyGenerator;
use HubertNNN\Imaginator\Core\Services\ImageFormatService;
use HubertNNN\Imaginator\Distribution\Services\ImageProcessorService;

abstract class ImaginatorCoreService
{
    /** @var KeyGenerator */
    protected $keyGenerator;

    /** @var ImageFormatService */
    protected $imageFormats;

    /** @var ImageProcessorService */
    protected $imageProcessors;


    public function __construct($keyGenerator, $imageFormats, $imageProcessors)
    {
        $this->keyGenerator = $keyGenerator;
        $this->imageFormats = $imageFormats;
        $this->imageProcessors = $imageProcessors;
    }


    // -----------------------------------------------------------------------------------------------------------------
    // Key generation and validation

    public function generateKey($type, $instance, $format, $extension = null)
    {
        if($extension === null) {
            $extension = $this->getExtension($type, $format);
        }

        return $this->keyGenerator->generateKey($type, $instance, $format, $extension);
    }

    public function validateKey($type, $instance, $format, $extension, $key)
    {
        $validKey = $this->keyGenerator->generateKey($type, $instance, $format, $extension);

        return $key == $validKey;
    }

    // -----------------------------------------------------------------------------------------------------------------
    // Extension generation

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

    // -----------------------------------------------------------------------------------------------------------------
}
