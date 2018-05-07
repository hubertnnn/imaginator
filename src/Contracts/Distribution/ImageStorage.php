<?php

namespace HubertNNN\Imaginator\Contracts\Distribution;

interface ImageStorage
{
    public function getFileLocation($type, $instance, $format, $extension);
}
