<?php

namespace HubertNNN\Imaginator\Distribution\Processors;

use HubertNNN\Imaginator\Contracts\Distribution\ImageProcessor;
use Intervention\Image\Constraint;

class JpegProcessor extends BaseInterventionProcessor implements ImageProcessor
{
    public function getExtension()
    {
        return 'jpg';
    }


    public function process($source, $target, $formatParameters = [])
    {
        $image = $this->load($source);

        $this->resize($image, $formatParameters);

        $quality = self::parameter($formatParameters, 'quality', 90);

        return $this->save($image, $target, 'jpg', $quality);
    }

}
