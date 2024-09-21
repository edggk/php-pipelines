<?php

namespace App\Traits;

trait HasLogs {
    protected array $logStack = [];

    /**
     * @return Array<mixed>
     */
    public function logs(): array
    {
        return $this->logStack;
    }

    protected function log(mixed $entry): void
    {
        $this->logStack[] = $entry;
    }
}
