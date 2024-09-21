<?php

namespace App\Interface;

interface DebuggableInterface{
    /**
     * @return Array<mixed>
     */
    public function logs(): array;
    public function debug(bool $enabled): self;
}

