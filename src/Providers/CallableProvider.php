<?php

namespace HubertNNN\Imaginator\Providers;

use HubertNNN\Imaginator\Contracts\ImageProvider;

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
