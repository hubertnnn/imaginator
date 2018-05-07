<?php

namespace HubertNNN\Imaginator\Integration\Laravel;

use Carbon\Carbon;
use HubertNNN\Imaginator\Contracts\Distribution\ImageDistributor;

class LaravelDistributor implements ImageDistributor
{
    public function send($image, $name)
    {
        return response()
            ->download($image, $name)
            ->setPublic()
            ->setMaxAge(31536000) //1 year
            ->setLastModified(Carbon::now())
            ->setExpires(Carbon::now()->addYear())
            ;
    }

    public function sendLater()
    {
        return response()
            ->make()
            ->setStatusCode(429)
            ->header('Retry-After', 5)
            ->setPublic()
            ->setMaxAge(4) //4 seconds
            ->setLastModified(Carbon::now())
            ->setExpires(Carbon::now()->addSeconds(4))
        ;
    }

    public function sendError()
    {
        return response()
            ->make()
            ->setStatusCode(404)
            ->setPublic()
            ->setMaxAge(604800) //1 week
            ->setLastModified(Carbon::now())
            ->setExpires(Carbon::now()->addWeek())
        ;
    }
}
