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

    public function getCircuitsByRef($ref)
    {
        $sql = self::$baseSQl . " WHERE circuitRef=?";
        $statement = DBHelper::runQuery($this->pdo, $sql, $ref);
        return $statement->fetchAll();
    }


}

class Constructor
{
    private $pdo;
    private static $baseSQL = 'SELECT constructorId,constructorRef,name,nationality,url FROM constructors';
    public function __construct($conn)
    {
        $this->pdo = $conn;
    }

    public function getAllContstructors()
    {

        $sql = self::$baseSQL;
        $statement = DBHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getConstructorByRef($ref)
    {
        $sql = self::$baseSQL . " WHERE constructorRef = ?";
        $statement = DBHelper::runQuery($this->pdo, $sql, $ref);
        return $statement->fetchAll();
    }

}

?>