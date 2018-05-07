<?php

namespace HubertNNN\Imaginator\Providers;

use HubertNNN\Imaginator\Contracts\ImageProvider;

class DummyProvider implements ImageProvider
{
    public function getImage($type, $instance)
    {
        return null;
    }
}
