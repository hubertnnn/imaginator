<?php

namespace HubertNNN\Imaginator\Services;

use HubertNNN\Imaginator\Contracts\EntityImageProvider;
use HubertNNN\Imaginator\Contracts\ImageProvider;

class ImageProviderService implements EntityImageProvider
{
    protected $providers = [];

    public function __construct($providers)
    {
        foreach ($providers as $key => $provider) {
            if(is_integer($key)) {
                $key = null;
            }

            $this->registerProvider($provider, $key);
        }
    }

    public function registerProvider($provider, $type = null)
    {
        $this->providers[$type][] = $provider;
    }

    public function getProviders($type = null)
    {
        $result = [];

        if($type === null) {
            foreach ($this->providers as $providers) {
                $result = array_merge($result, $providers);
            }
        } else {
            if(isset($this->providers[$type])) {
                $result = array_merge($result, $this->providers[$type]);
            }
            if(isset($this->providers[null])) {
                $result = array_merge($result, $this->providers[null]);
            }
        }

        return $result;
    }

    public function getImage($type, $instance)
    {
        /** @var ImageProvider $provider */
        foreach ($this->getProviders($type) as $provider) {
            $image = $provider->getImage($type, $instance);

            if($image !== null) {
                return $image;
            }
        }

        return null;
    }

    public function getTypeAndInstance($entity, $type = null)
    {
        /** @var ImageProvider $provider */
        foreach ($this->getProviders() as $provider) {
            if($provider instanceof EntityImageProvider) {
                $result = $provider->getTypeAndInstance($entity, $type);
            }

            if($result !== null) {
                return $result;
            }
        }

        return null;
    }
}
