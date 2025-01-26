<?php
namespace App\Core;

class Router {
    public function handleRequest(string $uri): void {
        if (str_ends_with($uri, '.xml')) {
            switch ($uri) {
            case '/software/index.xml':
                (new \App\Feeds\SoftwareFeed())->show();
                return;
            case '/blog/index.xml':
                (new \App\Feeds\BlogFeed())->show();
                return;
            }
        }

        session_start();
        $slug = $this->uriToCanonicalSlug($uri);
        $content = Router::showViewRaw($uri, $slug);
        $content = \App\Core\Utils::processAllAutolinks($content);
        $content = \App\Core\Utils::processAllAutocomments($content);
        echo \App\Core\Utils::processAllAutousernames($content);
    }

    private function showViewRaw(string $uri, string $slug): string {
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

            $view = $this->createView($slug, $db, $currentUser);

            if ($view === null) {
                throw new \App\Exceptions\NotFoundException($slug);
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
        } catch (\App\Exceptions\NotFoundException $e) {
            $view = \App\Views\NotFoundView::create($e->slug);
            return $this->createErrorContent($view, $currentUser, 404, $e->slug);
        } catch (\App\Exceptions\ForbiddenException $e) {
            $view = new \App\Views\ForbiddenErrorView($e->getMessage());
            return $this->createErrorContent($view, $currentUser, 403);
        } catch(\App\Exceptions\BadRequestException $e) {
            $view = new \App\Views\BadRequestErrorView($e->getMessage());
            return $this->createErrorContent($view, $currentUser, 400);
        } catch (\Exception $e) {
            // TODO: consider not using raw getMessage for security reasons
            $view = new \App\Views\InternalServerErrorView($e->getMessage());
            return $this->createErrorContent($view, $currentUser, 500);
        }
    }

    private function createErrorContent(
        \App\Views\View $view,
        ?\App\Models\UserUsernameModel $currentUser,
        int $code,
        ?string $slug = null,
    ): string {
        ob_clean();
        ob_start();
        $view->show();
        $result = ob_get_clean();
        $view = new \App\Views\TemplateView(
            $slug ?? '/',
            $result,
            null,
            $currentUser,
            $view->shouldDisplayComments(),
        );
        $view->show();
        http_response_code($code);
        return ob_get_clean();
    }

    private function createView(
        string $slug,
        \App\Core\Database $db,
        ?\App\Models\UserUsernameModel $currentUser,
    ): ?\App\Views\View {
        switch ($slug) {
        case '/menu/':
            return new \App\Views\MenuView($currentUser);
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
        case '/family/':
            return new \App\Views\FamilyView($db);
        case '/activity/':
            return new \App\Views\ActivityView($db, $currentUser);

        case '/removecomment/':
            return new \App\Views\RemoveCommentView($db, $currentUser);
        case '/disown/':
            return new \App\Views\DisownView($db, $currentUser);
        case '/adopt/':
            return new \App\Views\AdoptView($db, $currentUser);
        case '/editbio/':
            return new \App\Views\EditBioView($db, $currentUser);
        case '/logoutall/':
            return new \App\Views\LogoutAllView($db, $currentUser);
        case '/changepassword/':
            return new \App\Views\ChangePasswordView($db, $currentUser);

        case '/cms/software/':
            return new \App\Views\Cms\SoftwareCmsView($db, $currentUser);
        }

        if (str_starts_with($slug, '/u/')) {
            $username = substr($slug, 3);
            // TODO: better handling of trailing slash?
            $username = substr($username, 0, strlen($username) - 1);
            return new \App\Views\UserView($db, $username, $currentUser);
        }

        if (str_starts_with($slug, '/c/')) {
            $id = substr($slug, 3);
            $id = substr($id, 0, strlen($id) - 1);
            $slug = $db->getCommentSlug((int)$id);
            if ($slug !== null) {
                // TODO: this is stupid
                return new \App\Views\RedirectView("$slug#c$id");
            }
            return null;
        }

        $path = $this->findContentFilePath($slug);

        if ($path === null) {
            return null;
        }

        $content = \App\Models\ContentPageModel::fromFile($path, $slug);

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

        $getParamPos = strpos($uri, '?');

        if ($getParamPos !== false) {
            $uri = substr($uri, 0, $getParamPos);
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
