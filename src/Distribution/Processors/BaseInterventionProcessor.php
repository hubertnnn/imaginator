<?php

namespace HubertNNN\Imaginator\Distribution\Processors;

use HubertNNN\Imaginator\Contracts\Distribution\ImageProcessor;
use HubertNNN\Imaginator\Utilities\FileUtils;
use Intervention\Image\Constraint;
use Intervention\Image\Image;

abstract class BaseInterventionProcessor implements ImageProcessor
{
    /**
     * @param string $source
     * @return Image
     */
    protected function load($source)
    {
        //TODO: Make it framework agnostic

        $image = \Image::make($source);

        return $image;
    }

    /**
     * Will save a file keeping an exclusive lock during the saving process
     * @param Image $image image that will be saved
     * @param string $target path to file to be saved
     * @param string $format
     * @param mixed $quality
     * @return bool success
     */
    protected function save($image, $target, $format = null, $quality = 90)
    {
        FileUtils::createParentDirectory($target);

        $data = $image->encode($format, $quality);
        $saved = @file_put_contents($target, $data, LOCK_EX);

        // file_put_contents returns the number of bytes that were written to the file, or FALSE on failure.
        return $saved !== false;
    }

    /**
     * @param Image $image
     * @param mixed[] $formatParameters
     */
    protected function resize($image, $formatParameters)
    {
        $width = self::parameter($formatParameters, 'width', null);
        $height = self::parameter($formatParameters, 'height', null);
        $aspectRatio = self::parameter($formatParameters, 'aspectRatio', true);
        $upscale = self::parameter($formatParameters, 'upscale', true);

        if(($width === null) and ($height === null))
            return; // No resizing

        $image->resize($width, $height, function (Constraint $constraint) use($aspectRatio, $upscale) {
            if($aspectRatio)
                $constraint->aspectRatio();
            if(!$upscale)
                $constraint->upsize();
        });
    }

    protected static function parameter($formatParameters, $parameter, $default)
    {
        return isset($formatParameters[$parameter]) ? $formatParameters[$parameter] : $default;
    }
}
