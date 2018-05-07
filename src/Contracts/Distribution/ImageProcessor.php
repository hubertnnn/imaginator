<?php

namespace HubertNNN\Imaginator\Contracts\Distribution;

interface ImageProcessor
{
    public function process($source, $target, $formatParameters);
    public function getExtension();
}
