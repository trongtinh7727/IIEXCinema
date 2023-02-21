<?php

class Connection
{
    public static $connection = false;
    private function __construct()
    {
    }
    public static function connect()
    {
        try {
            if (!self::$connection) {
                $con  = new PDO(
                    'mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA,
                    DB_USER,
                    DB_PASS,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
                );
                // $con = new  mysqli(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA);
                self::$connection = $con;
                return self::$connection;
            }
        } catch (\PDOException $th) {
            echo $th->getMessage();
            exit;
        }
    }
}
