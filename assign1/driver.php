<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//require_once './helpers/helperFunc.inc.php';

include './helpers/helperFunc.inc.php';


function outputhtml()
{
    $s = '';

    if (isCorrectQuery('driverRef')) {
        $api_url = 'http://localhost/dakit711/assign1-web2/assign1/api/drivers.php';
        $content = file_get_contents($api_url . '?driverRef=' . urlencode($_GET['driverRef']));
        $driver_data = json_decode($content, true);
        foreach ($driver_data as $row) {
            $s .= '<p>Name: ' . $row["forename"] . ' ' . $row["surname"] . '</p>';
            $s .= '<p>DOB: ' . $row["dob"] . '</p>';
            $s .= '<p>Nationality: ' . $row["nationality"] . '</p>';
            $s .= '<p>URL: ' . $row["url"] . '</p>';
        }
    } else {
        echo "error, soemthing went wrong";


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
            <?php
            if (isset($_GET['driverRef'])) {
                echo outputhtml();
            }
            ?>
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
        &copy; 2024 COMP3512 Assignment #1.
    </footer>

</body>

</html>