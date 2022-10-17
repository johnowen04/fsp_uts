<?php
require_once("data.php");

class db {

    private static $mysqli = null;
    
    public static function get_connection() {
        if (self::$mysqli == null) {
            self::$mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME) or die("Connect failed: %s\n" . self::$mysqli->error);
        }

        return self::$mysqli;
    }
}