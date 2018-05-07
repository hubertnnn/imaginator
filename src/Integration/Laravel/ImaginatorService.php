<?php

namespace HubertNNN\Imaginator\Integration\Laravel;

use HubertNNN\Imaginator\ImaginatorService as BaseService;

class ImaginatorService extends BaseService
{
    public function routes()
    {
        $route = '/resources/image/{type}/{format}/{instance}/{key}.{extension}';
        \Route::get($route, '\\'.ImaginatorController::class.'@fetch');
    }
}
