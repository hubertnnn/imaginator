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

        $this->resize($image, $formatParameters);

        return $this->save($image, $target, 'png');
    }

}
