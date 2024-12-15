<?php
namespace App\Core;

require_once 'ContentPage.php';

class Router {
    public function handleRequest(string $uri): void {
        // TODO
        $slug = $this->uriToCanonicalSlug($uri);
        $path = $this->findContentFilePath($slug);
        $content = ContentPage::parse($path);
        echo $content->getContent();
    }

    private function uriToCanonicalSlug(string $uri): string {
        $indexHtmlPos = strpos($uri, '/index.html');

        if ($indexHtmlPos !== false) {
            $uri = substr($uri, 0, $indexHtmlPos);
        }

        if (strpos($uri, '.html') === false && !str_ends_with($uri, '/')) {
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
