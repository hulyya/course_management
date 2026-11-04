<?php
namespace src\core;

class DB {
    private ?\PDO $connection = null;

    public function __construct() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "course_management";
    
        try{
            $this->connection = new \PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function query(string $query, int|null $fetchMode = null, mixed ...$fetchModeArgs){
        return $this->connection->query($query, $fetchMode, $fetchModeArgs);
    }

    public function getConnection() {
        return $this->connection;
    }

}
?>