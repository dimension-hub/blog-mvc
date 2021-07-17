<?php
require_once "./application/lib/Dev.php";

use application\core\Router;

spl_autoload_register ( static function($class ) {
    $path = str_replace("\\", "/", $class . ".php");
    if (file_exists($path)) {
        require $path;
    }
});
session_start();

$router = new Router;
$router->run();