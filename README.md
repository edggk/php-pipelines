# PHP Pipeline

A flexible and extensible PHP pipeline implementation for chaining operations.

## Features

- Chain multiple operations in a pipeline
- Support for callable functions, static methods, and invokable classes
- Debugging capabilities
- Blocking mechanism to stop pipeline execution
- Lightweight and easy to use

## Usage

Here's a basic example of how to use the pipeline:

```php
use App\PipeLine;

$pipeline = new PipeLine();
$result = $pipeline
  ->pipe(fn($value) => $value * 2)
  ->pipe(fn($value) => $value + 5)
  ->pipe(fn($value) => $value * 3)
  ->run(5);

echo $result; // Outputs: 45
```

## Debugging

You can enable debugging to log the intermediate values:

```php
use App\PipeLine;

$pipeline = new PipeLine();
$result = $pipeline
  ->debug(true)
  ->pipe(fn($value) => $value * 2)
  ->pipe(fn($value) => $value + 5)
  ->run(5);

var_dump($result->logs()); // Logs: [[2, 7, 45]]
```

## Blocking

You can block the pipeline execution to prevent further processing:

```php
use App\PipeLine;
use App\PipeBlock;

$pipeline = new PipeLine();
$result = $pipeline
    ->pipe(fn($value) => $value * 2)
    ->pipe(function($value) {
        if ($value > 10) {
            return new PipeBlock("Value exceeds 10");
        }
        return $value;

    })
    ->pipe(fn($value) => $value + 5)
    ->run(6);

echo $result; // Outputs: 12
```
