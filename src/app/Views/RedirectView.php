<?php
namespace App\Views;

class RedirectView implements View {
    public function __construct(
        private readonly string $target
    ) {}

    public function show(): void {
        header("Location: $this->target");
    }

    public function shouldDisplayComments(): bool { return false; }
}
