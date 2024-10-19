<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'db-classes-inc.php';
require '../helpers/helperFunc.inc.php';


// Tell the browser to expect JSON rather than HTML
header('Content-type: application/json  charset=utf-8');
// indicate whether other domains can use this API
header("Access-Control-Allow-Origin: *");



try {
    $conn = DBHelper::createConnection(DBCONNSTRING);

    $circuitGateway = new Circuits($conn);
    if (isCorrectQuery('circuitRef')) {
        $results = $circuitGateway->getCircuitsByRef($_GET['circuitRef']);
    } else {
        $results = $circuitGateway->getAllCircuits();
    }
    echo json_encode($results, JSON_NUMERIC_CHECK, JSON_PRETTY_PRINT);
} catch (PDOException $e) {
    die($e->getMessage());
}


?>