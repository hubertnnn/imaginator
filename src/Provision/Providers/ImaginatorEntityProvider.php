<?php

namespace HubertNNN\Imaginator\Provision\Providers;

use HubertNNN\Imaginator\Contracts\Provision\ImageProvider;
use HubertNNN\Imaginator\Contracts\Provision\ImageProvidingEntity;

class ImaginatorEntityProvider implements ImageProvider
{
    public function getTypeAndInstance($entity, $type = null)
    {
        if($entity instanceof ImageProvidingEntity) {
            return $entity->provideImage($type);
        } else {
            return null;
        }
    }
}
