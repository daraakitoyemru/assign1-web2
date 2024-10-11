<?php
require_once './config.inc.php';
require_once './db-helper.inc.php';

class Circuits
{
    private static $baseSQl = "SELECT circuitId,circuitRef,name,location,country,lat,lng,alt,url FROM circuits";
    private $pdo;
    public function __construct($conn)
    {
        $this->pdo = $conn;
    }
    public function getAllCircuits()
    {

        $sql = self::$baseSQl;
        //$sql2 = "SELECT circuitId,circuitRef,name,location,country,lat,lng,alt,url FROM circuits";

        $statement = DBHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getCircuitsByName($circuitName)
    {
        $sql = self::$baseSQl . " WHERE circuitRef=?";
        $statement = DBHelper::runQuery($this->pdo, $sql, $circuitName);
        return $statement->fetchAll();
    }
}



?>