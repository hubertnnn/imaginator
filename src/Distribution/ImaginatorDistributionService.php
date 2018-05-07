<?php

namespace HubertNNN\Imaginator\Distribution;

use HubertNNN\Imaginator\Contracts\Distribution\ImageDistributor;
use HubertNNN\Imaginator\Contracts\Distribution\ImageProvider;
use HubertNNN\Imaginator\Contracts\Distribution\ImageStorage;
use HubertNNN\Imaginator\Contracts\Distribution\Imaginator;
use HubertNNN\Imaginator\Core\ImaginatorCoreService;

/**
 * Class ImaginatorService
 * @package HubertNNN\Imaginator
 */
class ImaginatorDistributionService extends ImaginatorCoreService implements Imaginator
{
    /** @var ImageProvider */
    protected $imageProvider;

    /** @var ImageStorage */
    protected $imageCache;

    /** @var ImageDistributor */
    protected $imageDistributor;


    public function __construct($keyGenerator, $imageFormats, $imageProcessors, $imageProvider, $imageCache, $imageDistributor)
    {
        parent::__construct($keyGenerator, $imageFormats, $imageProcessors);

        $this->imageProvider = $imageProvider;
        $this->imageCache = $imageCache;
        $this->imageDistributor = $imageDistributor;
    }

    // -----------------------------------------------------------------------------------------------------------------
    // File paths

    public function getImage($type, $instance)
    {
        return $this->imageProvider->getImage($type, $instance);
    }

    public function getCachedImage($type, $instance, $format, $extension)
    {
        return $this->imageCache->getFileLocation($type, $instance, $format, $extension);
    }

    // -----------------------------------------------------------------------------------------------------------------
    // Processing

    public function process($source, $target, $type, $format)
    {
        $config = $this->imageFormats->getConfig($type, $format);
        if($config === null)
            return null;

        $processor = $this->imageProcessors->getProcessor($config['processor']);
        if($processor === null)
            return null;

        return $processor->process($source, $target, $config);
    }

    // -----------------------------------------------------------------------------------------------------------------
    // Distributing

    public function send($image, $name)
    {
        return $this->imageDistributor->send($image, $name);
    }

    public function sendLater()
    {
        return $this->imageDistributor->sendLater();
    }

    public function sendError()
    {
        return $this->imageDistributor->sendError();
    }
}
