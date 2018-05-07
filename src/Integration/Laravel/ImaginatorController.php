<?php

namespace HubertNNN\Imaginator\Integration\Laravel;

use HubertNNN\Imaginator\Contracts\Imaginator;
use HubertNNN\Imaginator\Utilities\FileUtils;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImaginatorController extends Controller
{
    public function fetch(Imaginator $imaginator, $type, $format, $instance, $key, $extension)
    {
        /** @var ImaginatorService $imaginator */

        if(!$imaginator->validateKey($type, $instance, $format, $extension, $key)) {
            throw new NotFoundHttpException();
        };

        $cache = $imaginator->getCachedImage($type, $instance, $format, 'tmp');
        if(file_exists($cache)) {
            return $imaginator->send($cache);
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

            if($success) {
                FileUtils::delete($processing);
                return $imaginator->send($cache);
            } else {
                FileUtils::touch($error);
                FileUtils::delete($processing);
                return $imaginator->sendError();
            }

        } catch (\Exception $ex){
            FileUtils::touch($error);
            FileUtils::delete($processing);
            return $imaginator->sendError();
        }
    }
}
