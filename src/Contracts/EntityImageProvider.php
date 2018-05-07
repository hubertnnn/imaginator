<?php

namespace HubertNNN\Imaginator\Contracts;

interface EntityImageProvider extends ImageProvider
{
    public function getTypeAndInstance($entity, $type = null);
}
