<?php

namespace HubertNNN\Imaginator\Utilities;

class ClassUtils
{
    public static function buildClasses($definitions, $aliases = [], $callbackClass = null)
    {
        $result = [];

        foreach ($definitions as $key => $value) {
            $result[$key] = self::buildClass($value, $aliases, $callbackClass);
        }

        return $result;
    }

    public static function buildClass($definition, $aliases = [], $callbackClass = null)
    {
        if(is_string($definition)) {
            if(isset($aliases[$definition]))
                $definition = $aliases[$definition];

            return new $definition();
        }

        if(($callbackClass !== null) and is_callable($definition)) {
            return new $callbackClass($definition);
        }

        if(is_array($definition)) {
            $class = array_shift($definition);
            if(isset($aliases[$class]))
                $class = $aliases[$class];

            return new $class(...$definition);
        }

        if(is_object($definition)) {
            return $definition;
        }

        throw new \Exception('Definition cannot be resolved');
    }
}
