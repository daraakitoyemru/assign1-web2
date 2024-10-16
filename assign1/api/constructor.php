<?php
require_once './db-classes-inc.php';
require_once './db-helper.inc.php';
require_once './config.inc.php';


require '../helpers/helperFunc.inc.php';
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");

try {
    $conn = DBHelper::createConnection(DBCONNSTRING);
    $constructorGateway = new Constructor($conn);
    if (isCorrectQuery($_GET['ref'])) {
        $constructorResults = $constructorGateway->getConstructorByRef($_GET['ref']);
    } else {
        $constructorResults = $constructorGateway->getAllContstructors();
    }

    echo json_encode($constructorResults, JSON_NUMERIC_CHECK, JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    die($e->getMessage());
}

