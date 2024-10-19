<?php
require_once 'api/db-classes-inc.php';
require_once 'api/db-helper.inc.php';
require_once 'api/config.inc.php';

$raceResults = [];
$qualifyingResults = [];
$selectedRaceId = null;
$top3Winners = [];


try {
    $conn = DBHelper::createConnection('sqlite:./data/f1.db');
    $racesGateway = new Races($conn);
    $qualifyingGateway = new Qualifying($conn);
    $resultsGateway = new Results($conn);

    $raceResults = $racesGateway->getRaces2022();

    if (isset($_POST['raceId'])) {
        $selectedRaceId = $_POST['raceId'];
        $qualifyingResults = $qualifyingGateway->getQualifyingByRaceID($selectedRaceId);
        $allRaceResults = $resultsGateway->getResultsByRaceID($selectedRaceId);

        usort($allRaceResults, function ($a, $b) {
            return [$b['laps'], $b['points']] <=> [$a['laps'], $a['points']];
        });

        $top3Winners = array_slice($allRaceResults, 0, 3);
        $raceDetails = $racesGateway->getRacesbyRef($selectedRaceId);

    }
} catch (PDOException $e) {
    echo "Error fetching race or qualifying data: " . $e->getMessage();
}

function formatConstructorName($constructorRef)
{
    return ucwords(str_replace('_', ' ', $constructorRef));
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
                        <th>Race Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($raceResults)): ?>
                        <?php foreach ($raceResults as $race): ?>
                            <tr>
                                <td><?php echo $race['round']; ?></td>
                                <td><?php echo $race['raceName']; ?></td>
                                <td>
                                    <form method="post" action="browse.php">
                                        <input type="hidden" name="raceId" value="<?php echo $race['raceId']; ?>">
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

        <?php if (!empty($raceDetails)): ?>
            <section class="race-information">
                <h2>Race Information</h2>
                <p><strong>Race Name:</strong> <?php echo $raceDetails[0]['raceName']; ?></p>
                <p><strong>Round:</strong> <?php echo $raceDetails[0]['round']; ?></p>
                <p><strong>Circuit Name:</strong> <?php echo $raceDetails[0]['circuitName']; ?></p>
                <p><strong>Location:</strong> <?php echo $raceDetails[0]['location']; ?></p>
                <p><strong>Country:</strong> <?php echo $raceDetails[0]['country']; ?></p>
                <p><strong>Date:</strong> <?php echo $raceDetails[0]['date']; ?></p>
                <p><strong>Race URL:</strong> <a href="<?php echo $raceDetails[0]['url']; ?>" target="_blank">More Info</a>
                </p>
            </section>
        <?php endif; ?>

        <?php if (!empty($top3Winners)): ?>
            <section class="podium">
                <div class="podium-container">
                    <div class="podium-item second">
                        <span class="position">2</span>
                        <span
                            class="driver"><?php echo $top3Winners[1]['forename'] . ' ' . $top3Winners[1]['surname']; ?></span>
                        <span class="points"><?php echo $top3Winners[1]['points']; ?> pts</span>
                    </div>

                    <div class="podium-item first">
                        <span class="position">1</span>
                        <span
                            class="driver"><?php echo $top3Winners[0]['forename'] . ' ' . $top3Winners[0]['surname']; ?></span>
                        <span class="points"><?php echo $top3Winners[0]['points']; ?> pts</span>
                    </div>

                    <div class="podium-item third">
                        <span class="position">3</span>
                        <span
                            class="driver"><?php echo $top3Winners[2]['forename'] . ' ' . $top3Winners[2]['surname']; ?></span>
                        <span class="points"><?php echo $top3Winners[2]['points']; ?> pts</span>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <section class="qualifying-content">
            <?php if (!empty($qualifyingResults)): ?>
                <h3>Qualifying Results</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Position</th>
                            <th>Driver</th>
                            <th>Constructor</th>
                            <th>Q1</th>
                            <th>Q2</th>
                            <th>Q3</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($qualifyingResults as $result): ?>
                            <tr>
                                <td><?php echo $result['position']; ?></td>
                                <td>
                                    <a href="driver.php?driverRef=<?php echo $result['driverRef']; ?>">
                                        <?php echo $result['forename'] . ' ' . $result['surname']; ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="constructor.php?constructorRef=<?php echo $result['constructorRef']; ?>">
                                        <?php echo formatConstructorName($result['constructorRef']); ?>
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

        <section class="results-content">
            <?php if (!empty($allRaceResults)): ?>
                <h3>Race Results</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Position</th>
                            <th>Driver</th>
                            <th>Constructor</th>
                            <th>Laps</th>
                            <th>Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allRaceResults as $result): ?>
                            <tr>
                                <td><?php echo $result['position']; ?></td>
                                <td>
                                    <a href="driver.php?driverRef=<?php echo $result['driverRef']; ?>">
                                        <?php echo $result['forename'] . ' ' . $result['surname']; ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="constructor.php?constructorRef=<?php echo $result['constructorRef']; ?>">
                                        <?php echo formatConstructorName($result['constructorRef']); ?>
                                    </a>
                                </td>
                                <td><?php echo $result['laps']; ?></td>
                                <td><?php echo $result['points']; ?> pts</td>
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