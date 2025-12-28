<?php

class DbConnection {
    private static $instance = null;
    private $connection;
    
    private $host = 'db';
    private $database = 'tecweb_db';
    private $username = 'tecweb_user';
    private $password = 'tecweb_password';
    
    private function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4";
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Errore di connessione: " . $e->getMessage());
        }
    }
    
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new DbConnection();
        }
        return self::$instance;
    }
    
    public function get_connection() {
        return $this->connection;
    }
    
    private function __clone() {}
    
    public function __wakeup() {
        throw new Exception("Impossibile deserializzare il singleton");
    }
}
