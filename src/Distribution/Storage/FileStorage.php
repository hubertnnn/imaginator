<?php

namespace HubertNNN\Imaginator\Distribution\Storage;

use HubertNNN\Imaginator\Contracts\Distribution\ImageStorage;
use HubertNNN\Imaginator\Utilities\Sanitizer;

class FileStorage implements ImageStorage
{
    protected $baseDirectory;

    public function __construct($baseDirectory)
    {
        $this->baseDirectory = rtrim($baseDirectory, '/');
    }

    public function getFileLocation($type, $instance, $format, $extension)
    {
        $type = Sanitizer::sanitizeFileName($type);
        $instance = Sanitizer::sanitizeFileName($instance);
        $format = Sanitizer::sanitizeFileName($format);
        $extension = Sanitizer::sanitizeFileName($extension);

        return $this->baseDirectory . '/' . $type . '/' . $format . '/' . $instance . '.' . $extension;
    }
}
