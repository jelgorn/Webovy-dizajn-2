<?php
session_start();
include 'config.php';

// Dotaz na všechny zápasy
$sqlMatches = "SELECT matches.match_date, matches.match_time, home.id AS home_id, home.name AS home_team, 
               away.id AS away_id, away.name AS away_team
               FROM matches 
               JOIN teams AS home ON matches.home_team = home.id 
               JOIN teams AS away ON matches.away_team = away.id";
$resultMatches = $conn->query($sqlMatches);
$matches = [];

if ($resultMatches->num_rows > 0) {
    while ($row = $resultMatches->fetch_assoc()) {
        $matches[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match Menu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 30%;
            margin: auto;
            overflow: hidden;
        }
        h2 {
            text-align: center;
            margin: 20px 0;
            color: #333;
        }
        .match {
            background: #fff;
            margin: 20px 0;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .match p {
            margin: 0;
            padding: 5px 0;
            font-size: 1.2em;
        }
        .team-names {
            font-weight: bold;
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .team-names img {
            width: 50px;
            height: auto;
            margin: 0 10px;
        }
        .loga img {
            width: 150px; /* Set width to 150px */
            height: auto;
        } 
    </style>
</head>
<body>

    <div class="container">
        <h2>Matches</h2>
        <?php foreach ($matches as $match): ?>
            <div class="match">
                <p><?php echo htmlspecialchars($match['match_date']); ?></p>
                <p><?php echo htmlspecialchars($match['match_time']); ?></p>
                <div class="team-names">
                    <img src="loga/<?php echo htmlspecialchars($match['home_id']); ?>.png" alt="<?php echo htmlspecialchars($match['home_team']); ?> logo">
                    <p><?php echo htmlspecialchars($match['home_team']); ?> : <?php echo htmlspecialchars($match['away_team']); ?></p>
                    <img src="loga/<?php echo htmlspecialchars($match['away_id']); ?>.png" alt="<?php echo htmlspecialchars($match['away_team']); ?> logo">
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
