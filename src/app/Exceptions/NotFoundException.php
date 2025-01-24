<?php
namespace App\Exceptions;

class NotFoundException extends \Exception {
    public function __construct(
        public readonly string $slug,
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct("page kkard2$slug not found", $code, $previous);
    }
}
