<?php

namespace application\lib;

use application\core\View;
use PDO;
use PDOException;

class Db {

    protected PDO $db;

    public function __construct() {

        $config = require "application/config/db.php";
        try {

            $this->db = new PDO("mysql:host=".$config["host"].";dbname=".$config["name"], $config["user"], $config["password"]);
            // Prevents emulated prepares and activates error handling
            // PDO::ERRMODE_EXCEPTION
            $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) {

            // Prints error messages to file
            file_put_contents('./errors.log', 'Error: ' . $e->getMessage() . PHP_EOL, FILE_APPEND);
            // Shows generic error message to user
            View::errorCode(404); // ErrorDocument 503 server_error.html
            exit;
        }
    }

    public function query ($sql, $params = array() ) {

        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $stmt->db->bindValue(":".$key, $val);
            }
        }
        $stmt->execute();

        return $stmt;
    }

    public function row ($sql, $params = array() ): array {

        $result = $this->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function column ($sql, $params = array() ) {

        $result = $this->query($sql);
        return $result->fetchColumn();
    }

}