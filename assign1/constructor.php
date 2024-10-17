<?php
require_once'api/db-classes-inc.php';
require_once 'api/db-helper.inc.php';
require_once 'api/config.inc.php';

// Set default values for driver details
$driverName = "Not Available";
$driverNationality = "Not Available";
$driverURL = "#";

// Check if 'driverRef' is provided in the URL
if (isset($_GET['driverRef'])) {
    try {
        // Create a database connection
        $conn = DBHelper::createConnection(DBCONNSTRING);

        // Create an instance of the Drivers class
        $driversGateway = new Drivers($conn);

        // Get the driver details by reference
        $driverDetails = $driversGateway->getDriversByRef($_GET['driverRef']);

        // If driver details are found, update the variables
        if (!empty($driverDetails)) {
            $driver = $driverDetails[0];
            $driverName = $driver['forename'] . ' ' . $driver['surname'];
            $driverNationality = $driver['nationality'];
            $driverURL = $driver['url'];
        }

    } catch (PDOException $e) {
        echo "Error fetching driver details: " . $e->getMessage();
    }
} else {
    echo "No driver reference provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMP3512 Assignment #1</title>
    <link rel="stylesheet" href="constructor.css">

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
        <p><strong>Name:</strong> <?php echo $driverName; ?></p>
        <p><strong>Nationality:</strong> <?php echo $driverNationality; ?></p>
        <p><strong>URL:</strong> <a href="<?php echo $driverURL; ?>" target="_blank">More Info</a></p>
    </aside>

    <section class="main-content">
        <h2>Race Details</h2>
        <p>Rnd, Curcuit, Driver, Pos, Points</p>
    </section>
</main>

<footer>
    &copy; 2024 COMP3512 Assignment #1. All Rights Reserved.
</footer>

</body>
</html>
