<?php

namespace HubertNNN\Imaginator\Integration\Laravel;

use HubertNNN\Imaginator\Contracts\Distribution;
use HubertNNN\Imaginator\Utilities\FileUtils;
use Illuminate\Routing\Controller;

class ImaginatorController extends Controller
{
    public function fetch(Distribution\Imaginator $imaginator, $type, $format, $instance, $key, $extension)
    {
        if(!$imaginator->validateKey($type, $instance, $format, $extension, $key)) {
            return $imaginator->sendError();
        };

        $name = $instance . '.' . $extension;

        $cache = $imaginator->getCachedImage($type, $instance, $format, 'tmp');
        if(file_exists($cache)) {
            return $imaginator->send($cache, $name);
        }

        $error = $imaginator->getCachedImage($type, $instance, $format, 'error');
        if(file_exists($error)) {
            return $imaginator->sendError();
        }

        $processing = $imaginator->getCachedImage($type, $instance, $format, 'processing');
        if(file_exists($processing)) {
            return $imaginator->sendLater();
        }

        // Need to create a new image
        try {
            FileUtils::touch($processing);
            $image = $imaginator->getImage($type, $instance);
            $success = $imaginator->process($image, $cache, $type, $format);
        } catch (\Exception $ex){
            $success = false;
        }

        if($success) {
            FileUtils::delete($processing);
            return $imaginator->send($cache, $name);
        } else {
            FileUtils::touch($error);
            FileUtils::delete($processing);
            return $imaginator->sendError();
        }
    }
}
