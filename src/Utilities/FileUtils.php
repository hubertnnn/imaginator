<?php

namespace HubertNNN\Imaginator\Utilities;

class FileUtils
{
    public static function getParentDirectory($path)
    {
        $matches = [];
        $isInFolder = preg_match("/^(.*)\/([^\/]+)$/", $path, $matches);

        if(!$isInFolder) {
            return null;
        }

        return $matches[1];
    }

    public static function createParentDirectory($path)
    {
        $directory = self::getParentDirectory($path);

        if(is_dir($directory)) {
            return true;
        }

        return mkdir($directory, 0777, true);
    }

    public static function touch($path)
    {
        return self::createParentDirectory($path) and touch($path);
    }

    public static function delete($path)
    {
        unlink($path);
    }
}
