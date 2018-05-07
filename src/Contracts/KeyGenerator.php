<?php

namespace HubertNNN\Imaginator\Contracts;

interface KeyGenerator
{
    public function generateKey($type, $instance, $format, $extension);
}
