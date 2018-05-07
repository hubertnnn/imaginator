<?php

namespace HubertNNN\Imaginator\Integration\Laravel;

use HubertNNN\Imaginator\Contracts\Distribution;
use HubertNNN\Imaginator\Provision\ImaginatorProvisionService;

class ImaginatorLaravelService extends ImaginatorProvisionService
{
    public function routes()
    {
        $route = '/resources/image/{type}/{format}/{instance}/{key}.{extension}';
        \Route::get($route, '\\'.ImaginatorController::class.'@fetch')->name('imaginator.fetch');
    }

    public function distribution()
    {
        return resolve(Distribution\Imaginator::class);
    }
}
