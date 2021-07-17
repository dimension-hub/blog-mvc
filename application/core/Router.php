<?php

namespace application\core;

class Router {

    protected array $routes = array();
    protected array $params = array();

    public function __construct () {

        $arr = require "application/config/routes.php";
        foreach ($arr as $key => $value) {
            $this->add($key, $value);
        }
    }

    public function add ( string $route, array $params ): void {

        $route = '#^'.$route.'$#';
        $this->routes[$route] = $params;
    }

    public function match (): bool {

        #debug($_SERVER);
        $url = trim( $_SERVER["REQUEST_URI"], "/?" );
        foreach ($this->routes as $route => $params) {
            if ( preg_match($route, $url, $matches)) {
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function run (): void {


        if( $this->match() ) {

            $path = "application\controllers\\".ucfirst($this->params["controller"])."Controller";
            if (class_exists($path)) {
                $action = $this->params["action"]."Action";
                if (method_exists($path, $action)) {
                    $controller = new $path($this->params);
                    $controller->$action();
                }
                else {
                    View::errorCode(404);
                }
            }
            else {
                View::errorCode(404);
            }
        }
        else {
            View::errorCode(404);
        }
    }
}