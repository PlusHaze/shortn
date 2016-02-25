<?php

class Database {

    private $dbHost = "localhost";
    private $dbName = "";
    private $dbUser = "";
    private $dbPass = "I#";

    private static $instance;
    private static $con;

    public static function getInstance() {
        if (is_null(self::$instance))
            self::$instance = new Database();

        return self::$con;
    }

    public function __construct() {
        $connectionString = "mysql:dbname=$this->dbHost;dbname=$this->dbName";

        try {
            self::$con = new PDO($connectionString, $this->dbUser, $this->dbPass);
            self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
