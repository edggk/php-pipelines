<?php

namespace App\Interface;

interface PipeInterface extends DebuggableInterface {
    public function setValue(mixed $value): self;
    public function value(): mixed;
    public function pipe(callable|string $callback): self;
    public function debug(bool $enabled): self;
}

