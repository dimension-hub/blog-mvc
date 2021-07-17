<?php

namespace application\core;

class View {

    public string $path;
    public array $route;
    public string $layout = "default";


    public function __construct ($route) {

        $this->route = $route;
        $this->path =$route["controller"]."/".$route["action"];
    }

    public function render($title, $vars = []) {

        $path = "application/views/".$this->path.".php";
        if (file_exists($path)) {

            ob_start();
            require  $path;
            $content = ob_get_clean();
            require "application/views/layouts/".$this->layout.".php";
        }
    }

    public function redirect ($url) {

        header("Location: ".$url);
        exit;
    }

    public static function errorCode($code) {

        http_response_code($code);
        $path = "application/views/errors/".$code.".php";
        if (file_exists($path)) {
            require $path;
        }
        exit;
    }

    /**
     * @throws \JsonException
     */
    public function message ($status, $message): void {

        exit(json_encode(["status" => $status, "message" => $message], JSON_THROW_ON_ERROR));
    }

    /**
     * @throws \JsonException
     */
    public function location ($url): void {


        exit(json_encode(["url" => $url], JSON_THROW_ON_ERROR));
    }
}