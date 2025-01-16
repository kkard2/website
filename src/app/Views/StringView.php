<?php
namespace App\Views;

class StringView implements View {
    public function __construct(
        private readonly string $content,
    ) {}

    public function show(): void {
        echo $this->content;
    }
}
