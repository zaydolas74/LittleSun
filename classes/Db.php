<?php
class Db
{
    private static $conn;

    public static function getConnection()
    {
        if (self::$conn === null) {
            self::$conn = new PDO('mysql:host=localhost;dbname=littlesun', 'root', 'root');
            return self::$conn;
        }
        return self::$conn;
    }
}
