<?php

namespace HubertNNN\Imaginator\Utilities;

class Sanitizer
{
    /**
     * Removes characters that are unsafe for use in file paths
     * @param $source
     */
    public static function sanitizeFileName($source)
    {
        return preg_replace( '/[^a-z0-9]+/', '-', strtolower( $source ));
    }
}
