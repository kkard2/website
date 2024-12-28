<?php
namespace App\Views;

class InternalServerErrorView implements View {
    private ContentView $inner;

    public function __construct(string $message) {
        $this->inner = new ContentView(
            "/",
            "<h1>500 Internal Server Error</h1>$message"
        );
    }

    public function show(): void {
        $this->inner->show();
    }
}
