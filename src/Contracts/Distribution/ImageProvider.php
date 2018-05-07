<?php

namespace HubertNNN\Imaginator\Contracts\Distribution;

interface ImageProvider
{
    public function getImage($type, $instance);
}
