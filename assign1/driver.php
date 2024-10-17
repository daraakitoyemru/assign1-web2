<?php
//require_once'/api/db-classes-inc.php';
require_once 'api/db-classes-inc.php';
require_once 'helpers/helperFunc.inc.php';

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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMP3512 Assignment #1</title>
    <link rel="stylesheet" href="driver.css">

</head>

<body>

    <header>
        <h1>F1 DASHBOARD PROJECT</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="browse.php">Browse</a>
            <a href="api.php">APIs</a>
        </nav>
    </header>

    <main>
        <aside>

            <h2>Driver Details</h2>
            <?php echo outputhtml() ?>
            <!-- <p>Name:</p>
            <p>DoB:</p>
            <p>Age:</p>
            <p>Nationality:</p>
            <p>URL:</p> -->
        </aside>

        <section class="main-content">
            <h2>Race Details</h2>
            <p>Rnd, Curcuit, Pos, Points</p>
        </section>
    </main>

    <footer>
        &copy; 2024 COMP3512 Assignment #1. All Rights Reserved.
    </footer>

</body>

</html>