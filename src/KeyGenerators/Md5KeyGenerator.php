<?php

namespace HubertNNN\Imaginator\KeyGenerators;

use HubertNNN\Imaginator\Contracts\KeyGenerator;

class Md5KeyGenerator implements KeyGenerator
{
    protected $masterKey;

    public function __construct($masterKey)
    {
        $this->masterKey = md5($masterKey);
    }

    public function generateKey($type, $instance, $format, $extension)
    {
        return md5($this->masterKey . md5($type) . md5($instance) . md5($format) . md5($extension));
    }
}
