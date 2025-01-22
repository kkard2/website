<?php
namespace App\Core;

class Router {
    public function handleRequest(string $uri): void {
        session_start();
        $content = Router::showViewRaw($uri);
        $content = \App\Core\Utils::processAllAutolinks($content);
        echo \App\Core\Utils::processAllAutousernames($content);
    }

    private function showViewRaw(string $uri): string {
        // TODO: this should probably be rewritten, looks ugly
        //       also maybe not being in the router
        ob_start();
        $currentUser = null;
        try {
            // TODO: values from env
            $db = \App\Core\Database::connect('localhost', 'root', '', 'kkard2');

            if ($db === null) {
                throw new \Exception('could not connect to the database');
            }

            $currentUser = $db->getUserBySession(session_id());

            $slug = $this->uriToCanonicalSlug($uri);
            $view = $this->createView($slug, $db);

            if ($view === null) {
                $view = \App\Views\NotFoundView::create($slug);
                $view->show();
                $result = ob_get_clean();
                $view = new \App\Views\TemplateView(
                    $slug,
                    $result,
                    $db,
                    $currentUser,
                    $view->shouldDisplayComments(),
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
                $result,
                $db,
                $currentUser,
                $view->shouldDisplayComments(),
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
                $result,
                null,
                $currentUser,
                $view->shouldDisplayComments(),
            );
            $view->show();
            http_response_code(500);
            return ob_get_clean();
        }
    }

    private function createView(
        string $slug,
        \App\Core\Database $db,
    ): ?\App\Views\View {
        switch ($slug) {
        case '/software/':
            return \App\Views\SoftwareView::create();
        case '/blog/':
            return \App\Views\BlogView::create();
        case '/register/':
            return new \App\Views\RegisterView($db);
        case '/login/':
            return new \App\Views\LoginView($db);
        case '/logout/':
            return new \App\Views\LogoutView($db);
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
