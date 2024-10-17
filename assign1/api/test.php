<?php
require './db-classes-inc.php';
require '../helpers/helperFunc.inc.php';
echo getcwd();

$circuitGateway = getGateway('Circuits');
//print_r($circuitGateway->getAllCircuits());

function outputhtml()
{
    $driversGateway = getGateway('Drivers');
    if ($driversGateway) {
        if (isCorrectQuery('driverRef')) {
            foreach ($driversGateway->getDriversByRef($_GET['driverRef']) as $row) {
                $s = '<p>Name: ' . $row["forename"] . ' ' . $row["surname"] . '</p>';
                $s .= '<p>DOB: ' . $row["dob"] . '</p>';
                $s .= '<p>Age: ' . $row["age"] . '</p>';
                $s .= '<p>Nationality: ' . $row["nationality"] . '</p>';
                $s .= '<p>URL: ' . $row["url"] . '</p>';
            }
        } else {
            echo "error, soemthing went wrong";
        }

    }
    return $s;
}
echo outputhtml();