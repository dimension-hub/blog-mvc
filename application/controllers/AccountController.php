<?php

namespace application\controllers;

use application\core\Controller;

class AccountController extends Controller {

    /**
     * @throws \JsonException
     */
    public function loginAction () {

        if (!empty($_POST)) {
            $this->view->message("error", "Текст ошибки");
        }
        $this->view->render("Login");
    }

    public function registerAction () {

        $this->view->render("Register");
    }
}
