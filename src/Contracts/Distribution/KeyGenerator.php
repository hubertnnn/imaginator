<?php

namespace HubertNNN\Imaginator\Contracts\Distribution;

interface KeyGenerator
{
    public function generateKey($type, $instance, $format, $extension);
}
