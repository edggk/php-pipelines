<?php

namespace App;

use App\Interface\DebuggableInterface;
use App\Interface\PipeInterface;
use App\Pipe;
use App\Traits\HasLogs;
use App\Utils\Callback;

class PipeLine implements DebuggableInterface {
    use HasLogs;

    protected bool $debugging = false;
    protected PipeBlock | bool $hadBlockage = false;

    /** @var Array<callable> $commands */
    protected array $commands = [];

    public function __construct(protected PipeInterface $piper = new Pipe())
    {}

    public function pipe(callable|string $callback): self
    {
        $this->commands[] = Callback::toCallable($callback);
        
        return $this;
    }

    public function run(mixed $value): mixed
    {
        $this->hadBlockage = false;
        $this->piper->setValue($value);

        if($this->debugging){
            $this->piper->debug();
        }

        foreach($this->commands as $command){
            $this->piper->pipe($command);
        }

        $this->hadBlockage = $this->piper->blockage();

        if($this->debugging){
            $this->log(
                $this->piper->logs()
            );
            $this->piper->debug(false);
        }

        return $this->piper->value();
    }

    public function debug(bool $enable = true): self
    {
        $this->debugging = $enable;
    
        return $this;
    }

    public function hadBlockage(): bool
    {
        return $this->hadBlockage;
    }
}

