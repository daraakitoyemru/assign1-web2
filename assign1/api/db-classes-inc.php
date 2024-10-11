<?php
require_once './config.inc.php';
require_once './db-helper.inc.php';

class Circuits
{

    private $pdo;
    public function __construct($conn)
    {
        $this->pdo = $conn;
    }
    public function getAllCircuits()
    {

        $sql = "SELECT circuitId,circuitRef,name,location,country,lat,lng,alt,url FROM circuits";
        $statement = DBHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }
}



?>