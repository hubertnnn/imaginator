<?php

namespace HubertNNN\Imaginator\Integration\Laravel;

use Illuminate\Support\Facades\Facade;

class ImaginatorFacade extends Facade {
    /**
     * Get the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'HubertNNN\Imaginator\Contracts\Provision\Imaginator'; // the IoC binding.
    }
}
