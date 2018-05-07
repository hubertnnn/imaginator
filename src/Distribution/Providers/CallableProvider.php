<?php

namespace HubertNNN\Imaginator\Distribution\Providers;

use HubertNNN\Imaginator\Contracts\Distribution\ImageProvider;

class CallableProvider implements ImageProvider
{
    protected $callable;

    public function __construct($callable)
    {
        $this->callable = $callable;
    }

    public function getImage($type, $instance)
    {
        return call_user_func($this->callable, $type, $instance);
    }
}
