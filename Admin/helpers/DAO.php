<?php

require_once 'config.php';

class DAO
{
    private static $dbh;

    public static function get_db_connect()
    {
        try {
            if (self::$dbh === null) {
                self::$dbh = new PDO(DSN, DB_USER, DB_PASSWORD, array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false, 
                ));
            }
        } catch (PDOException $e) {
            echo "接続エラー: " . $e->getMessage(); 
            die();
        }

        return self::$dbh;
    }
}
