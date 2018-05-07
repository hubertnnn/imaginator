<?php

namespace HubertNNN\Imaginator\Core\KeyGenerators;

use HubertNNN\Imaginator\Contracts\Distribution\KeyGenerator;

class Sha1KeyGenerator implements KeyGenerator
{
    protected $masterKey;

    public function __construct($masterKey)
    {
        $this->masterKey = sha1($masterKey);
    }

    public function generateKey($type, $instance, $format, $extension)
    {
        return sha1($this->masterKey . sha1($type) . sha1($instance) . sha1($format) . sha1($extension));
    }
}
