<?php
namespace App\Views;

class NotFoundView implements View {
    private ContentView $inner;

    public function __construct(string $slug) {
        $this->inner = new ContentView(
            $slug,
            "<h1>404 Not Found</h1>Page '$slug' does not exist"
        );
    }

    public function show(): void {
        $this->inner->show();
    }
}
