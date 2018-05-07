<?php

namespace HubertNNN\Imaginator\Contracts;

interface ImageUrlGenerator
{
    public function buildUrl($type, $instance, $format, $key, $extension);
}
