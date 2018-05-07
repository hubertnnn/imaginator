<?php

namespace HubertNNN\Imaginator\Services;

class MultiProviderService
{
    protected $providers = [];

    public function __construct($providers)
    {
        foreach ($providers as $provider) {
            $this->registerProvider($provider);
        }
    }

    public function registerProvider($provider)
    {
        $this->providers[] = $provider;
    }

    public function __call($name, $arguments)
    {
        foreach ($this->providers as $provider) {
            $result = call_user_func_array([$provider, $name], $arguments);

            if($result !== null) {
                return $result;
            }
        }

        return null;
    }
}
