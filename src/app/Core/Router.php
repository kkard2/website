<?php
namespace App\Core;

class Router {
    public function handleRequest(string $uri): void {
        try {
            $slug = $this->uriToCanonicalSlug($uri);
            $view = $this->createView($slug);

            if ($view === null) {
                $view = new \App\Views\NotFoundView($slug);
            }

            $view->show();
        } catch (\Exception $e) {
            // TODO: consider not using raw getMessage for security reasons
            $view = new \App\Views\InternalServerErrorView($e->getMessage());
            $view->show();
        }
    }

    private function createView(string $slug): ?\App\Views\View {
        switch ($slug) {
        case '/software/':
            return new \App\Views\SoftwareView;
        }

        $path = $this->findContentFilePath($slug);

        if ($path === null) {
            return null;
        }

        $content = \App\Models\ContentPageModel::fromFile($path);

        if ($content === null) {
            return null;
        }

        return new \App\Views\ContentView($slug, $content->getContent());
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
