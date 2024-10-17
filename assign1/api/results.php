<?php
require_once './db-classes-inc.php';
require '../helpers/helperFunc.inc.php';
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");

try {
    $conn = DBHelper::createConnection(DBCONNSTRING);
    $resultsGateway = new Results($conn);
    if (isCorrectQuery('resRef')) {
        $results = $resultsGateway->getResultsByRaceID($_GET['resRef']);
    } else if (isCorrectQuery('driverRes')) {
        $results = $resultsGateway->getResultsByDriver($_GET['driverRes']);
    }
    echo json_encode($results, JSON_NUMERIC_CHECK, JSON_PRETTY_PRINT);
} catch (PDOException $e) {
    die($e->getMessage());
}