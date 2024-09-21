<?php

namespace App\Utils;

use InvalidArgumentException;

class Callback {

    public static function toCallable(callable|string $callback): callable
    {
        if(is_callable($callback)){
            return $callback;
        }

        if(class_exists($callback)){
            $class = new $callback;

            if(is_callable($class)){
                return new $class;
            }
        }

        throw new InvalidArgumentException('Callback must be invocable');
    }
}

