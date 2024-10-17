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
    private static $baseSQL = "SELECT constructorId,constructorRef,name,nationality,url FROM constructors";
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
        $sql = self::$baseSQL . " WHERE constructorRef=?";
        $statement = DBHelper::runQuery($this->pdo, $sql, $ref);
        return $statement->fetchAll();
    }

}

class Drivers
{
    private $pdo;
    private static $baseSQL = "SELECT driverId,driverRef,number,code,forename,surname,dob,nationality,url FROM drivers";
    public function __construct($conn)
    {
        $this->pdo = $conn;
    }

    public function getAllDrivers()
    {
        $sql = self::$baseSQL;
        $statement = DBHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getDriversByRef($ref)
    {
        $sql = self::$baseSQL . " WHERE driverRef=?";
        $statement = DBHelper::runQuery($this->pdo, $sql, $ref);
        return $statement->fetchAll();
    }
    public function getDriversByRace($raceID)
    {
        $sql = "SELECT d.driverId,d.driverRef,d.number,d.code,d.forename,d.surname,d.dob,d.nationality,d.url FROM drivers d
        JOIN results r ON r.driverId = d.driverId where r.raceId =?";
        $statement = DBHelper::runQuery($this->pdo, $sql, $raceID);
        return $statement->fetchAll();
    }
}

class Races
{
    private $pdo;
    private static $baseSQL = "select c.name , c.location, c.country, r.date , r.url , r.round, r.year, r.time from races r
    JOIN circuits c on c.circuitId = r.circuitId";
    public function __construct($conn)
    {
        $this->pdo = $conn;
    }

    public function getRacesbyRef($ref)
    {
        $sql = self::$baseSQL . " where c.circuitId =?";

        $statement = DBHelper::runQuery($this->pdo, $sql, $ref);
        return $statement->fetchAll();
    }

    public function getRaces2022()
    {
        $sql = self::$baseSQL . " where r.year = 2022 order by r.round";
        $statement = DBHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }
}

class Qualifying
{
    private $pdo;
    private static $baseSQL = "select q.position, q.q1, q.q2, q.q3, q.number, d.driverRef, d.code, d.forename, d.surname, r.name, r.round, r.year,
    r.date, c.name, c.constructorRef, c.nationality from qualifying q 
    join drivers d on q.driverId = d.driverId 
    join races r on r.raceId = q.raceId 
    join constructors c on c.constructorId = q.constructorId";
    public function __construct($conn)
    {
        $this->pdo = $conn;
    }
    public function getQualifyingByRaceID($ref)
    {
        $sql = self::$baseSQL . " where r.raceId =? order by q.position ASC";
        $statement = DBHelper::runQuery($this->pdo, $sql, $ref);
        return $statement->fetchAll();
    }
}

class Results
{
    private $pdo;
    private static $baseSQL = "SELECT res.number,res.grid, res.position, res.positionText, res.positionOrder, res.points, res.laps, res.time,
    res.milliseconds, res.fastestLap, res.rank, res.fastestLapTime, res.fastestLapSpeed, d.driverRef, d.code, d.forename, d.surname,
     r.name, r.round, r.year, r.date, c.name, c.constructorRef, c.nationality
    from results res
    join drivers d on d.driverId = res.driverId 
    join races r on r.raceId = res.raceId 
    join constructors c on c.constructorId = res.constructorId";
    public function __construct($conn)
    {
        $this->pdo = $conn;
    }

    public function getResultsByRaceID($ref)
    {
        $sql = self::$baseSQL . " where r.raceId =? order by res.grid ASC";
        $statement = DBHelper::runQuery($this->pdo, $sql, $ref);
        return $statement->fetchAll();
    }

    public function getResultsByDriver($ref)
    {
        $sql = self::$baseSQL . " where LOWER(d.forename || '_' || d.surname)=?";
        $statement = DBHelper::runQuery($this->pdo, $sql, $ref);
        return $statement->fetchAll();
    }

}

?>