<?php

namespace HubertNNN\Imaginator\Contracts\Provision;

interface ImageUrlGenerator
{
    public function buildUrl($type, $instance, $format, $key, $extension);
}
