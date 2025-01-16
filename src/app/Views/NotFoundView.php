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
        echo "<h1>404 Not Found</h1>Page '$this->slug' does not exist";
    }
}
