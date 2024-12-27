<?php
declare(strict_types=1);

spl_autoload_register(function ($className) {
    $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    $file = __DIR__ . '/' . $classPath . '.php';

    if (file_exists($file)) {
        require_once $file;
    } else {
        throw new Exception("Unable to load class: $className");
    }
});

require_once 'app/Core/Router.php';

use \App\Core\Router;
$router = new Router();
$router->handleRequest($_SERVER['REQUEST_URI']);
?>
<!--
<html>
    <head>
        <meta charset="utf-8">
        <title>##title##</title>
        <link rel="stylesheet" href="/style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <header>
            <a href="/" class="filesystem-root">/</a>
            <a href="/software">/software</a>
            <a href="/blog">/blog</a>
            <a href="/rss">/rss</a>
            <a href="/people">/people</a>
            <a href="/ophs">/ophs</a>
        </header>
        <div>
            <h1>test h1</h1>
            <h2>test h2</h2>
            <h3>test h3</h3>
        </div>
    </body>
</html>
-->
