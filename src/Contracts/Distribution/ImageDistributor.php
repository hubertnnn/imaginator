<?php

namespace HubertNNN\Imaginator\Contracts\Distribution;

interface ImageDistributor
{
    public function send($image, $name);
    public function sendLater();
    public function sendError();
}
