<?php
require_once './db-classes-inc.php';
function isCorrectQuery($param)
{
    if (isset($_GET[$param]) && !empty($_GET[$param])) {
        return true;
    }
    return false;
}

// creates an instance of a given object and returns it
function getGateway($classname)
{
    try {
        if (!class_exists($classname)) {
            throw new Exception("Class $classname does not exist.");
        }
        $conn = DBHelper::createConnection(DBCONNSTRING);
        $gateway = new $classname($conn);
        return $gateway;
    } catch (Exception $e) {
        die($e->getMessage());
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}