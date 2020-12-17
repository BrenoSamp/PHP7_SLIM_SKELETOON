<?php

namespace App\Database;

use PDO;

class Sql
{

    private $conn;

    public function __construct(string $dbhost, string $dbname, string $dbuser, string $dbpass)
    {

        $this->conn = new \PDO(
            "mysql:dbname=$dbname;host=$dbhost",
            $dbuser,
            $dbpass,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_PERSISTENT => false,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }

    private function setParams($statement, $parameters = [])
    {

        foreach ($parameters as $key => $value) {

            $this->bindParam($statement, $key, $value);
        }
    }

    private function bindParam($statement, $key, $value)
    {

        $statement->bindParam($key, $value);
    }

    public function query(string $rawQuery,array $params = [])
    {

        $stmt = $this->conn->prepare($rawQuery);

        $this->setParams($stmt, $params);

        $stmt->execute();

        return $stmt;
    }
}
