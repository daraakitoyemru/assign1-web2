<?php
require_once './db-classes-inc.php';
require '../helpers/helperFunc.inc.php';
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");

try {
    $conn = DBHelper::createConnection(DBCONNSTRING);
    $driversGateway = new Drivers($conn);

    if (isCorrectQuery('ref')) {
        $results = $driversGateway->getDriversByRef($_GET['ref']);
    } else if (isCorrectQuery('race')) {
        $results = $driversGateway->getDriversByRace($_GET['race']);
    } else {
        $results = $driversGateway->getAllDrivers();
    }

    echo json_encode($results, JSON_NUMERIC_CHECK, JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    die($e->getMessage());
}