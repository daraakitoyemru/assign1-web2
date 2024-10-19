<?php
require_once 'api/db-classes-inc.php';
require_once 'api/db-helper.inc.php';
require_once 'api/config2.inc.php';

$driverName = "Not Available";
$driverDOB = "Not Available";
$driverAge = "Not Available";
$driverNationality = "Not Available";
$driverURL = "#";
$raceResults = [];

if (isset($_GET['driverRef'])) {
    try {
        $conn = DBHelper::createConnection(DBCONNSTRING2);
        $driversGateway = new Drivers($conn);
        $resultsGateway = new Results($conn);
        $driverDetails = $driversGateway->getDriversByRef($_GET['driverRef']);

        if (!empty($driverDetails)) {
            $driver = $driverDetails[0];
            $driverName = $driver['forename'] . ' ' . $driver['surname'];
            $driverDOB = $driver['dob'];

            // Calculate age
            $birthdate = new DateTime($driverDOB);
            $today = new DateTime('today');
            $driverAge = $today->diff($birthdate)->y . ' years old';

            $driverNationality = $driver['nationality'];
            $driverURL = $driver['url'];

            // Get race results for the driver
            $raceResults = $resultsGateway->getResultsByDriver(strtolower($driver['forename']) . '_' . strtolower($driver['surname']));
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
            <p><strong>Name:</strong> <?php echo $driverName; ?></p>
            <p><strong>Date of Birth:</strong> <?php echo $driverDOB; ?></p>
            <p><strong>Age:</strong> <?php echo $driverAge; ?></p>
            <p><strong>Nationality:</strong> <?php echo $driverNationality; ?></p>
            <p><strong>URL:</strong> <a href="<?php echo $driverURL; ?>" target="_blank">More Info</a></p>
        </aside>

        <section class="main-content">
            <h2>Race Details</h2>
            <table>
                <thead>
                    <tr>
                        <th>Round</th>
                        <th>Circuit</th>
                        <th>Position</th>
                        <th>Points</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($raceResults)): ?>
                        <?php foreach ($raceResults as $result): ?>
                            <tr>
                                <td><?php echo $result['round']; ?></td>
                                <td><?php echo $result['circuitName']; ?></td>
                                <td><?php echo $result['position'] ?: 'DNF'; // Did not finish ?></td>
                                <td><?php echo $result['points']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No race results available for this driver.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        &copy; 2024 COMP3512 Assignment #1.
    </footer>

</body>

</html>