<?php

namespace App;

use App\Interface\PipeInterface;
use App\Traits\HasLogs;
use App\Utils\Callback;

class Pipe implements PipeInterface
{
    use HasLogs;

    protected bool $debugging = false;
    protected PipeBlock|bool $blocked = false;

    protected mixed $value;

    public function __construct(mixed $value = null)
    {
        $this->setValue($value);
    }

    public function setValue(mixed $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function pipe(callable|string $callback): self
    {
        if($this->blocked !== false) {
            return $this;
        }

        $callback = Callback::toCallable($callback);
        $response = call_user_func($callback, $this->value);

        if($response instanceof PipeBlock) {
            $this->blocked = $response;
        } else {
            $this->value = $response;
            if($this->debugging){
                $this->log($this->value);
            }
        }

        return $this;
    }

    public function debug(bool $enable = true): self
    {
        $this->debugging = $enable;

        return $this;
    }

    public function value(): mixed
    {
        return $this->value;
    }
}
