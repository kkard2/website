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

require_once 'App/Core/Router.php';

use \App\Core\Router;
$router = new Router();
$router->handleRequest($_SERVER['REQUEST_URI']);
?>
