<?php

namespace HubertNNN\Imaginator\Services;

class ImageProcessorService
{
    protected $processors = [];

    public function __construct($processors = [])
    {
        foreach ($processors as $type => $processor)
        {
            $this->registerProcessor($type, $processor);
        }
    }

    public function registerProcessor($type, $processor)
    {
        $this->processors[$type] = $processor;
    }

    public function getProcessor($type)
    {
        if(isset($this->processors[$type]))
            return $this->processors[$type];

        return null;
    }
}
