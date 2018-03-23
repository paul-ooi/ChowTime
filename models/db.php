<?php
require_once 'credentials.php';

class Database {
    private static $dsn = "mysql:host=50.62.209.13;dbname=http5202_chowTime";
    private static $db;

    private function __construct() {

    }

    public static function getDb() {
        if (!isset(self::$db)) {
            try {
                self::$db = new PDO(self::$dsn, Credentials::getName(), Credentials::getPass());
            } catch (PDOException $err) {
                echo $err->getMessage();
            }
        }
        return self::$db;
    }// end of function getDb

}

 ?>
