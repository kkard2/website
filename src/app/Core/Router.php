<?php
namespace App\Core;

require_once 'ContentPage.php';
require_once __DIR__ . '/../Views/ContentView.php';

class Router {
    public function handleRequest(string $uri): void {
        $slug = $this->uriToCanonicalSlug($uri);

        switch ($slug) {
        case '/software/':
            
            break;
        }

        $path = $this->findContentFilePath($slug);

        $content = ContentPage::parse($path);
        $view = new \App\Views\ContentView($slug, $content->getContent());
        $view->show();

        echo $content->getContent();
    }

    private function uriToCanonicalSlug(string $uri): string {
        $indexHtmlPos = strpos($uri, '/index.html');

        if ($indexHtmlPos !== false) {
            $uri = substr($uri, 0, $indexHtmlPos);
        }

        if (str_ends_with($uri, '.html') === false && !str_ends_with($uri, '/')) {
            $uri = $uri . '/';
        }

        return $uri;
    }

    private function findContentFilePath(string $slug): ?string {
        $path = 'content' . $slug;

        if (str_ends_with($slug, '/')) {
            $path .= 'index.html';
        }

        if (file_exists($path)) {
            return $path;
        } else {
            return null;
        }
    }
}
