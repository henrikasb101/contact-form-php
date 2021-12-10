<?php

namespace app;

require_once 'config.php';
use PDO;

class Database {
    private static $db = null;

    public static function get() {
        if (self::$db === null) {
            self::$db = new PDO('mysql:host='.DB_ADDRESS.';dbname='.DB_NAME, DB_USERNAME, DB_PASSWORD);
        }

        return self::$db;
    }
}
