<?php

namespace HubertNNN\Imaginator\Distribution\Services;

use HubertNNN\Imaginator\Contracts\Distribution\ImageProvider;

class ImageProviderService implements ImageProvider
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
}
