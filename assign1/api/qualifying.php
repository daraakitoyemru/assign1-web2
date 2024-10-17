<?php
require_once './db-classes-inc.php';
require '../helpers/helperFunc.inc.php';
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");

try {
    $conn = DBHelper::createConnection(DBCONNSTRING);
    $qualifyingGateway = new Qualifying($conn);
    if (isCorrectQuery('ref')) {
        $results = $qualifyingGateway->getQualifyingByRaceID($_GET['ref']);
    }
    echo json_encode($results, JSON_NUMERIC_CHECK, JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    die($e->getMessage());
}