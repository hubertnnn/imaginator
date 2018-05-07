<?php

namespace HubertNNN\Imaginator\Contracts;

interface ImageStorage
{
    public function getFileLocation($type, $instance, $format, $extension);
}
