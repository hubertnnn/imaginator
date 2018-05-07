<?php

namespace HubertNNN\Imaginator\Providers;

use HubertNNN\Imaginator\Contracts\ImageProvider;

class FilesystemProvider implements ImageProvider
{
    protected $baseDirectory;

    public function __construct($baseDirectory)
    {
        $this->baseDirectory = rtrim($baseDirectory, '/');
    }

    public function getImage($type, $instance)
    {
        // Sanitize input
        $type = preg_replace('/[^\w-]/', '', $type);
        $instance = preg_replace('/[^\w-]/', '', $instance);

        return $this->baseDirectory . '/' . $type . '/' . $instance;
    }
}
