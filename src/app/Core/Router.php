<?php
namespace App\Core;

class Router {
    public function handleRequest(string $uri): void {
        $content = Router::showViewRaw($uri);
        echo \App\Core\Utils::processAllAutolinks($content);
    }

    private function showViewRaw(string $uri): string {
        // TODO: this should probably be rewritten, looks ugly
        //       also maybe not being here
        ob_start();
        try {
            $slug = $this->uriToCanonicalSlug($uri);
            $view = $this->createView($slug);

            if ($view === null) {
                $view = \App\Views\NotFoundView::create($slug);
                $view->show();
                $result = ob_get_clean();
                $view = new \App\Views\TemplateView(
                    $slug,
                    $result
                );
                ob_start();
                $view->show();
                http_response_code(404);
                return ob_get_clean();
            }

            $view->show();
            $result = ob_get_clean();
            ob_start();
            $view = new \App\Views\TemplateView(
                $slug,
                $result
            );
            $view->show();
            return ob_get_clean();
        } catch (\Exception $e) {
            ob_clean();
            ob_start();
            // TODO: consider not using raw getMessage for security reasons
            $view = new \App\Views\InternalServerErrorView($e->getMessage());
            $view->show();
            $result = ob_get_clean();
            $view = new \App\Views\TemplateView(
                '/',
                $result
            );
            $view->show();
            http_response_code(500);
            return ob_get_clean();
        }
    }

    private function createView(string $slug): ?\App\Views\View {
        switch ($slug) {
        case '/software/':
            return \App\Views\SoftwareView::create();
        case '/blog/':
            return \App\Views\BlogView::create();
        }

        $path = $this->findContentFilePath($slug);

        if ($path === null) {
            return null;
        }

        $content = \App\Models\ContentPageModel::fromFile($path);

        if ($content === null) {
            return null;
        }

        return new \App\Views\StringView(
            $content->getContent()
        );
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
