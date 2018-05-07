<?php

namespace HubertNNN\Imaginator\Contracts\Provision;

interface Imaginator
{
    public function entity($entity, $format, $type = null);
    public function image($type, $instance, $format);
}
