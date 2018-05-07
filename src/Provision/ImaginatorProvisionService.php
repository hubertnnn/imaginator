<?php

namespace HubertNNN\Imaginator\Provision;

use HubertNNN\Imaginator\Contracts\Provision\ImageProvider;
use HubertNNN\Imaginator\Contracts\Provision\ImageUrlGenerator;
use HubertNNN\Imaginator\Contracts\Provision\Imaginator;
use HubertNNN\Imaginator\Core\ImaginatorCoreService;

class ImaginatorProvisionService extends ImaginatorCoreService implements Imaginator
{
    /** @var ImageProvider */
    protected $imageProvider;

    /** @var ImageUrlGenerator */
    protected $imageUrlGenerator;


    public function __construct($keyGenerator, $imageFormats, $imageProcessors, $imageProvider, $imageUrlGenerator)
    {
        parent::__construct($keyGenerator, $imageFormats, $imageProcessors);

        $this->imageProvider = $imageProvider;
        $this->imageUrlGenerator = $imageUrlGenerator;
    }


    // -----------------------------------------------------------------------------------------------------------------
    // Public API

    public function entity($entity, $format, $type = null)
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
}
