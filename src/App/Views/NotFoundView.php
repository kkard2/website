<?php
namespace App\Views;

class NotFoundView implements View {
    private function __construct(
        private readonly string $slug
    ) {}

    public static function create(string $slug): View {
        return new NotFoundView($slug);
    }

    public function show(): void {
        echo "<h1>404 Not Found</h1>Page 'kkard2$this->slug' does not exist";
    }

    public function shouldDisplayComments(): bool { return false; }
}
