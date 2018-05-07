<?php

namespace HubertNNN\Imaginator\Contracts\Provision;

interface ImageProvider
{
    public function getTypeAndInstance($entity, $type = null);
}
