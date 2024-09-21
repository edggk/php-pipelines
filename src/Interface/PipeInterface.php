<?php

namespace App\Interface;

use App\PipeBlock;

interface PipeInterface extends DebuggableInterface {
    public function setValue(mixed $value): self;
    public function value(): mixed;
    public function pipe(callable|string $callback): self;
    public function debug(bool $enabled): self;
    public function blockage(): PipeBlock | bool;
}

