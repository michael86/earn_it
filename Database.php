<?php

class Database {
    public $conn = '';

    /**
     * constructior for db class
     * @param array $cnf
     * 
     */
    public function __construct(array $cnf) {
        $dsn = "mysql:host={$cnf['DB_HOST']};port={$cnf['DB_PORT']};dbname={$cnf['DB_NAME']}";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
 
        try {
            $this->conn = new PDO($dsn, $cnf['DB_USER'], $cnf['DB_PASS'], $options);
        } catch (PDOException $e) {
            throw new Exception("Databse connection failed: {$e->getMessage()}");
        }
    }
}