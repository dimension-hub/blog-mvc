<?php
ini_set('display_errors', E_ALL);
error_reporting(E_ALL);

function debug ($str) {

    echo "<pre>";
        var_dump ($str);
    echo "</pre>";
    exit;
}