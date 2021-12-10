<?php

namespace App\Fram\Factories;

use PDO;

class PDOFactory
{
    public static function getMysqlConnection(
        $db = "pineapplepizza",
        $dbhost = "db",
        $dbport = 3306,
        $dbuser = "root",
        $dbpasswd = "password"
    ) {
        return new PDO('mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $db . '', $dbuser, $dbpasswd);
    }
}
