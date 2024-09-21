<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\PipeBlock;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use App\Pipe;

class OperationStatic
{
    public function __invoke(mixed $val): mixed
    {
        return self::handle($val);
    }

    public static function handle(mixed $val): mixed
    {
        return $val * 2;
    }
}

final class PipeTest extends TestCase
{
    #[Test]
    public function itCanChainPipeFunction(): void
    {
        $pipe = new Pipe(5);

        $operation = fn ($val) => $val + 5;

        $pipe->pipe($operation)
            ->pipe($operation);

        $this->assertSame($pipe->value(), 15);
    }

    #[Test]
    public function itCanChainStaticClassString(): void
    {
        $pipe = new Pipe(5);

        $pipe->pipe(['OperationStatic', 'handle'])
            ->pipe(['OperationStatic', 'handle']);

        $this->assertSame($pipe->value(), 20);
    }

    #[Test]
    public function itCanChainInvokeClass(): void
    {
        $pipe = new Pipe(5);

        $pipe->pipe(OperationStatic::class)
            ->pipe(new OperationStatic);

        $this->assertSame($pipe->value(), 20);
    }
    
    #[Test]
    public function itShouldThrowWhenInvalidInvokableClass(): void
    {
        $pipe = new Pipe(5);

        $this->expectException(InvalidArgumentException::class);
        $pipe->pipe('random/class/name/fake');
    }

    #[Test]
    public function itShouldRespectBlockAndNotRunFurtherPipes(): void
    {
        $pipe = new Pipe(5);

        $operation = fn ($val) => $val + 5;

        $pipe->pipe($operation)
            ->pipe($operation)
            ->pipe(fn($val) => new PipeBlock('testing'))
            ->pipe($operation)
            ->pipe($operation)
            ->pipe($operation);

        $this->assertSame($pipe->value(), 15);
    }

    #[Test]
    public function itShouldHaveLogging(): void
    {
        $pipe = new Pipe(5);
        $operation = fn ($val) => $val + 5;

        $pipe->pipe(fn($val) => $val * 2)
            ->debug(true)
            ->pipe($operation)
            ->pipe($operation)
            ->debug(false)
            ->pipe($operation);

        $this->assertEquals([15, 20], $pipe->logs());
    }
}
