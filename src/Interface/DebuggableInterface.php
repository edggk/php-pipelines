<?php

namespace App\Interface;

interface DebuggableInterface{
    /**
     * @return Array<mixed>
     */
    public function logs(): array;
    public function clearLogs(): void;
    public function debug(bool $enabled): self;
}

