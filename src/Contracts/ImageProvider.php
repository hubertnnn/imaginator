<?php

namespace HubertNNN\Imaginator\Contracts;

interface ImageProvider
{
    public function getImage($type, $instance);
}
