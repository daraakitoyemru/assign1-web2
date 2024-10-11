<?php

require_once './db-classes-inc.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Tell the browser to expect JSON rather than HTML
header('Content-type: application/json');
// indicate whether other domains can use this API
header("Access-Control-Allow-Origin: *");



try {
    $conn = DBHelper::createConnection(DBCONNSTRING);

    $circuitGateway = new Circuits($conn);
    if (isCorrectQuery('ref')) {
        $results = $circuitGateway->getCircuitsByName($_GET['ref']);
    } else {
        $results = $circuitGateway->getAllCircuits();
    }
    echo json_encode($results, JSON_NUMERIC_CHECK, JSON_PRETTY_PRINT);
} catch (PDOException $e) {
    die($e->getMessage());
}
function isCorrectQuery($param)
{
    if (isset($_GET[$param]) && !empty($_GET[$param])) {
        return true;
    }
    return false;
}

?>