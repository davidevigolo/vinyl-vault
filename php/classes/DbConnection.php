<?php

class DbConnection {
    private static $instance = null;
    private $connection;

    private $host = 'localhost';
    private $database = 'dvigolo';
    private $username = 'dvigolo';
    private $password = 'oX2Uheib2phiequi';

    private function __construct() {
        try {
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

            if ($this->connection->connect_error) {
                throw new Exception("Errore di connessione: " . $this->connection->connect_error);
            }

            $this->connection->set_charset("utf8mb4");
            mysqli_report(MYSQLI_REPORT_OFF); // Disabilita le eccezioni di mysqli, permettendoci di gestire gli errori singolarmente
        } catch (Exception $e) {
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

    private function __clone() {
    }

    public function __wakeup() {
        throw new Exception("Impossibile deserializzare il singleton");
    }
}
