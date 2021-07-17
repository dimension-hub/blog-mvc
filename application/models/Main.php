<?php

namespace application\models;

use application\core\Model;

class Main extends Model {

    public function getNews(): array {

        return $this->db->row("SELECT title, desk FROM news");
    }
}
