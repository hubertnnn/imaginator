<?php

namespace HubertNNN\Imaginator\Integration\Laravel;

use HubertNNN\Imaginator\Contracts\Provision\ImageUrlGenerator;

class LaravelUrlGenerator implements ImageUrlGenerator
{
    public function buildUrl($type, $instance, $format, $key, $extension)
    {
        return route('imaginator.fetch', [
            'type' => $type,
            'instance' => $instance,
            'format' => $format,
            'key' => $key,
            'extension' => $extension,
        ]);
    }
}
