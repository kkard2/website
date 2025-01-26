<?php
namespace App\Views;

class InternalServerErrorView implements View {
    public function __construct(
        private readonly string $message
    ) {}

    public function show(): void {
        echo "<h1>500 Internal Server Error</h1>$this->message";
    }

    public function shouldDisplayComments(): bool { return false; }
}
