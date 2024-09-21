<?php 

namespace App;

class PipeBlock {
  public function __construct(
    protected readonly string $message = 'Pipeline Blocked'
  )
  {}

  public function message(): string
  {
    return $this->message;
  }
}
