<?php

namespace HubertNNN\Imaginator\Contracts;

interface ImageDistributor
{
    public function send($image);
    public function sendLater();
    public function sendError();
}
