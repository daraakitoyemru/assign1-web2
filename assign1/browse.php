<?php
require_once 'api/db-classes-inc.php';
require_once 'api/db-helper.inc.php';
require_once 'api/config.inc.php';

$raceResults = [];
$qualifyingResults = [];
$selectedRaceId = null;
$top3Winners = [];


try {
    $conn = DBHelper::createConnection(DBCONNSTRING);
    $racesGateway = new Races($conn);
    $qualifyingGateway = new Qualifying($conn);
    $resultsGateway = new Results($conn);

    $raceResults = $racesGateway->getRaces2022();

    if (isset($_POST['raceId'])) {
        $selectedRaceId = $_POST['raceId'];
        $qualifyingResults = $qualifyingGateway->getQualifyingByRaceID($selectedRaceId);
        $allRaceResults = $resultsGateway->getResultsByRaceID($selectedRaceId);
        $top3Winners = array_slice($allRaceResults, 0, 3);
    }

} catch (PDOException $e) {
    echo "Error fetching race or qualifying data: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMP3512 Assignment #1</title>
    <link rel="stylesheet" href="browse.css">
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
            <h2>2022 F1 Races</h2>
            <table>
                <thead>
                    <tr>
                        <th>Round</th>
                        <th>Circuit</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($raceResults)): ?>
                        <?php foreach ($raceResults as $race): ?>
                            <tr>
                                <td><?php echo $race['round']; ?></td>
                                <td><?php echo $race['name']; ?></td>
                                <td>
                                    <form method="post" action="browse.php">
                                        <input type="hidden" name="raceId" value="<?php echo $race['round']; ?>">
                                        <button type="submit">View Race</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No races found for the 2022 season.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </aside>

        <section class="podium">
            <?php if (!empty($top3Winners)): ?>
                <h3>Top 3 Winners for Race <?php echo $selectedRaceId; ?></h3>
                <table>
                    <thead>
                        <tr>
                            <th>Position</th>
                            <th>Driver</th>
                            <th>Constructor</th>
                            <th>Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($top3Winners as $winner): ?>
                            <tr>
                                <td><?php echo $winner['position']; ?></td>
                                <td><?php echo $winner['forename'] . ' ' . $winner['surname']; ?></td>
                                <td>
                                    <a href="constructor.php?constructorRef=<?php echo $winner['constructorRef']; ?>">
                                        <?php echo $winner['constructorRef']; ?>
                                    </a>
                                </td>
                                <td><?php echo $winner['points']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>

        <section class="main-content">
            <?php if (!empty($qualifyingResults)): ?>
                <h3>Qualifying</h3>
                <table>
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Constructor</th>
                            <th>Q1</th>
                            <th>Q2</th>
                            <th>Q3</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($qualifyingResults as $result): ?>
                            <tr>
                                <td><?php echo $result['forename']; ?></td>
                                <td><?php echo $result['surname']; ?></td>
                                <td>
                                    <a href="constructor.php?constructorRef=<?php echo $result['constructorRef']; ?>">
                                        <?php echo $result['constructorRef']; ?>
                                    </a>
                                </td>
                                <td><?php echo $result['q1']; ?></td>
                                <td><?php echo $result['q2']; ?></td>
                                <td><?php echo $result['q3']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        &copy; 2024 COMP3512 Assignment #1.
    </footer>

</body>

</html>