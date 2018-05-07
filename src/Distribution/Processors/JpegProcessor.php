<?php

namespace HubertNNN\Imaginator\Distribution\Processors;

use HubertNNN\Imaginator\Contracts\Distribution\ImageProcessor;

class JpegProcessor extends BaseInterventionProcessor implements ImageProcessor
{
    public function getExtension()
    {
        return 'jpg';
    }


    public function process($source, $target, $formatParameters = [])
    {
        $image = $this->load($source);

        $width = isset($formatParameters['width']) ? $formatParameters['width'] : 0;
        $height = isset($formatParameters['height']) ? $formatParameters['height'] : 0;

        $quality = isset($formatParameters['quality']) ? $formatParameters['quality'] : 90;


        $image->resize($width, $height);

        return $this->save($image, $target, 'jpg', $quality);
    }

}
