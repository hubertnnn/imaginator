<?php

namespace HubertNNN\Imaginator\Services;

class ImageFormatService
{
    protected $formats = [];
    protected $compiled = [];

    public function __construct($formats)
    {
        $this->formats = $formats;
    }

    public function getConfig($type, $format)
    {
        $formats = $this->compileFormats($type);
        if(isset($formats[$format]))
            return $formats[$format];

        $formats = $this->compileFormats('*');
        if(isset($formats[$format]))
            return $formats[$format];

        return null;
    }

    protected function compileFormats($type)
    {
        if(!isset($this->compiled[$type])) {
            $formats = [];

            if(isset($this->formats[$type])) {
                foreach ($this->formats[$type] as $key => $value) {
                    if(is_integer($key)) {
                        $formats = array_merge($formats, $this->compileFormats($value));
                    } else {
                        $formats[$key] = $value;
                    }
                }
            }

            $this->compiled[$type] = $formats;
        }

        return $this->compiled[$type];
    }
}
