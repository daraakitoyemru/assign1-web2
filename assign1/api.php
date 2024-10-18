<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMP3512 Assignment #1</title>
    <link rel="stylesheet" href="api.css">

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
        <section class="main-content">
            <div class="column-1">
                <h2>URL</h2>
                <a href="api/circuits.php">/api/circuits.php</a>
                <a href="api/circuits.php?circuitRef=sepang<">/api/circuits.php?circuitRef=sepang</a>
                <a href="/api/constructors.php">/api/constructors.php</a>
                <a href="/api/constructors.php?constructorRef=mclaren">/api/constructors.php?constructorRef=mclaren</a>
                <a href="/api/drivers.php">/api/drivers.php</a>
                <a href="/api/drivers.php?driverRef=norris">/api/drivers.php?driverRef=norris</a>
                <a href="/api/drivers.php?race=1106">/api/drivers.php?race=?</a>
                <a href="/api/races.php?racesRef=">/api/races.php?racesRef=</a>
                <a href="">/api/races.php</a>
                <a href="">/api/qualifying.php?qualRef=?</a>
                <a href="">/api/results.php?resRef=?</a>
                <a href="">/api/results.php?driver=lando_norris</a>
            </div>
            <div class="column-2">
                <h2>Description</h2>
                <p>Returns all the circuits</p>
                <p>Return just a specific circuit</p>
                <p>Returns all the constructors</p>
                <p>Returns just a specific constructor</p>
                <p>Returns all the drivers for the season</p>
                <p>Returns just the specified driver</p>
                <p>Returns the drivers within a given race</p>
                <p>Returns just the specified race</p>
                <p>Returns the races within the 2022 season ordered by round</p>
                <p>Returns the qualifying results for the specified race</p>
                <p>Returns the results for the specified race</p>
                <p>Returns all the results for a given driver</p>
            </div>
        </section>
    </main>

    <footer>
        &copy; 2024 COMP3512 Assignment #1.
    </footer>

</body>

</html>