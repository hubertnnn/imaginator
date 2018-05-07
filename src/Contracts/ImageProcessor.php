<?php

namespace HubertNNN\Imaginator\Contracts;

interface ImageProcessor
{
    public function process($source, $target, $formatParameters);
    public function getExtension();
}
