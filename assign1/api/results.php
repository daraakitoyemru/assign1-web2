<?php
require_once './db-classes-inc.php';
require '../helpers/helperFunc.inc.php';
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");

try {
    $conn = DBHelper::createConnection(DBCONNSTRING);
    $resultsGateway = new Results($conn);
    if (isCorrectQuery('ref')) {
        $results = $resultsGateway->getResultsByRaceID($_GET['ref']);
    } else if (isCorrectQuery('driver')) {
        $results = $resultsGateway->getResultsByDriver($_GET['driver']);
    }
    echo json_encode($results, JSON_NUMERIC_CHECK, JSON_PRETTY_PRINT);
} catch (PDOException $e) {
    die($e->getMessage());
}