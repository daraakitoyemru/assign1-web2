<?php

//require_once '../api/db-helper.inc.php';


function isCorrectQuery($param)
{
    if (isset($_GET[$param]) && !empty($_GET[$param])) {
        return true;
    }
    return false;
}

//creates an instance of a given object and returns it
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
        //for easier error checking when making sure a gateway was in fact created
        error_log($e->getMessage());
        return null;
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return null;
    }
}