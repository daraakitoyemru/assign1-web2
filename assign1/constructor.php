<?php
require_once 'api/db-classes-inc.php';
require_once 'api/db-helper.inc.php';
require_once 'api/config.inc.php';

$constructorName = "Not Available";
$constructorNationality = "Not Available";
$constructorURL = "#";
$raceResults = [];

if (isset($_GET['constructorRef'])) {
    try {
        $conn = DBHelper::createConnection(DBCONNSTRING);
        $constructorGateway = new Constructor($conn);
        $resultsGateway = new Results($conn);
        $constructorDetails = $constructorGateway->getConstructorByRef($_GET['constructorRef']);

        if (!empty($constructorDetails)) {
            $constructor = $constructorDetails[0];
            $constructorName = $constructor['name'];
            $constructorNationality = $constructor['nationality'];
            $constructorURL = $constructor['url'];
            $raceResults = $resultsGateway->getResultsByConstructor($_GET['constructorRef']);
        }

    } catch (PDOException $e) {
        echo "Error fetching constructor details: " . $e->getMessage();
    }
} else {
    echo "No constructor reference provided.";
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
            <h2>Constructor Details</h2>
            <p><strong>Name:</strong> <?php echo $constructorName; ?></p>
            <p><strong>Nationality:</strong> <?php echo $constructorNationality; ?></p>
            <p><strong>URL:</strong> <a href="<?php echo $constructorURL; ?>" target="_blank">More Info</a></p>
        </aside>

        <section class="main-content">
            <h2>Race Details</h2>
            <table>
                <thead>
                    <tr>
                        <th>Round</th>
                        <th>Circuit</th>
                        <th>Driver</th>
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
                                <td><?php echo $result['forename'] . ' ' . $result['surname']; ?></td>
                                <td><?php echo $result['position']; ?></td>
                                <td><?php echo $result['points']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No race results available for this constructor.</td>
                        </tr>
                    <?php endif;

                    ?>

                </tbody>
            </table>
        </section>
    </main>

    <footer>
        &copy; 2024 COMP3512 Assignment #1.
    </footer>

</body>

</html>