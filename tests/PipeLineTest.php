<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use App\PipeLine;

final class PipeLineTest extends TestCase
{
    #[Test]
    public function itCorrectlyExecutesCommands(): void
    {
        $operation = fn($value) => $value * 5;

        $pipeLine = new PipeLine();
        
        $pipeLine->pipe($operation)
            ->pipe($operation)
            ->pipe(fn($value) => $value + 5)
            ->pipe($operation);

        $result = $pipeLine->run(5);
        
        $this->assertSame((5 * 5 * 5 + 5) * 5, $result);
    }

    #[Test]
    public function itClearsResultsBetweenRuns(): void
    {
        $operation = fn($value) => $value * 5;

        $pipeLine = new PipeLine();
        
        $pipeLine->pipe($operation)
            ->pipe($operation)
            ->pipe(fn($value) => $value + 5)
            ->pipe($operation);

        $result = $pipeLine->run(3);
        $result = $pipeLine->run(7);
        $result = $pipeLine->run(5);
        
        $this->assertSame((5 * 5 * 5 + 5) * 5, $result);
    }
}
