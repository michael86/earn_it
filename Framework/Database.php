<?php

namespace Framework;

use PDO;

class Database {
    public $conn;

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

    /**
     * query method 
     * @param string $query - Query string
     * @param array $args - Array for params
     * @return PDOStatement
     * @throws PDOEsxception 
     */
    public function query (string $query, array $args=[] ) {
        try {
            $sth = $this->conn->prepare($query);

            //Bind params
            foreach($params as $param => $value) {
                $sth->bindValue(':'.$param, $value);
            }

            $sth->execute();
            return $sth;
        } catch (PDOEcxception $e) {
            throw new Exception("Query failed to execute.\n{$e}");
        }
    }
}