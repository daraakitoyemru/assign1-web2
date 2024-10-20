<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once './db-classes-inc.php';
require '../helpers/helperFunc.inc.php';
header('Content-type: application/json;');
header("Access-Control-Allow-Origin: *");

try {
    $conn = DBHelper::createConnection(DBCONNSTRING);
    $driversGateway = new Drivers($conn);

    if (isCorrectQuery('driverRef')) {
        $results = $driversGateway->getDriversByRef($_GET['driverRef']);
    } else if (isCorrectQuery('race')) {
        $results = $driversGateway->getDriversByRace($_GET['race']);
    } else if (isCorrectQuery(('driver'))) {
        $results = $driversGateway->getDriversByName($_GET['driver']);
    } else {
        $results = $driversGateway->getAllDrivers();
    }

    echo json_encode($results, JSON_NUMERIC_CHECK, JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    die($e->getMessage());
}