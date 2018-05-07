<?php

namespace HubertNNN\Imaginator\Contracts\Distribution;

interface Imaginator
{
    public function generateKey($type, $instance, $format);
    public function validateKey($type, $instance, $format, $extension, $key);

    public function getExtension($type, $format);

    public function getImage($type, $instance);
    public function getCachedImage($type, $instance, $format, $extension);
    public function process($source, $target, $type, $format);

    public function send($image, $name);
    public function sendLater();
    public function sendError();
}
