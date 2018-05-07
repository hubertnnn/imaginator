<?php

namespace HubertNNN\Imaginator\Distribution\Processors;

use HubertNNN\Imaginator\Contracts\Distribution\ImageProcessor;

class PngProcessor extends BaseInterventionProcessor implements ImageProcessor
{
    public function getExtension()
    {
        return 'png';
    }


    public function process($source, $target, $formatParameters = [])
    {
        $image = $this->load($source);

        $width = isset($formatParameters['width']) ? $formatParameters['width'] : 0;
        $height = isset($formatParameters['height']) ? $formatParameters['height'] : 0;

        $image->resize($width, $height);

        return $this->save($image, $target, 'png');
    }

}
