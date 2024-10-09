<?php
require_once './config.inc.php';
try {
    $pdo = new PDO(DBCONNSTRING);


    $result = $pdo->query('Select * from circuits');
    echo json_encode($result->fetchAll(PDO::FETCH_ASSOC), JSON_NUMERIC_CHECK);

} catch (PDOException $e) {
    die($e->getMessage());
}


?>