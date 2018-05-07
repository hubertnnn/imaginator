<?php

namespace HubertNNN\Imaginator\Contracts\Provision;

interface ImageProvidingEntity
{
    /**
     * @param string $type If entity provides mor then 1 image this value determines the image to pick
     * @return array Returns [$type, $instance] pair
     */
    public function provideImage($type = null);
}
