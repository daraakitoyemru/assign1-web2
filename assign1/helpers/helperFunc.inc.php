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
