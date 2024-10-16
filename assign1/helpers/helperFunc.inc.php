<?php
function isCorrectQuery($param)
{
    if (isset($_GET[$param]) && !empty($_GET[$param])) {
        return true;
    }
    return false;
}