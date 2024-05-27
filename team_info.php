<?php
include 'config.php';

if(isset($_GET['id'])) {
    $team_id = $_GET['id'];

    // Získanie informácií o tíme z databázy na základe ID
    $sql = "SELECT * FROM teams WHERE id = $team_id";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $team = $result->fetch_assoc();
    } else {
        echo "Team not found";
    }
} else {
    echo "Team ID not provided";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $team['name']; ?> - Info</title>
    <!-- Prípadné ďalšie štýly -->
</head>
<body>
    <h2><?php echo $team['name']; ?> - Info</h2>

<ul>
    <li><strong>Team Name:</strong> <?php echo $team['name']; ?></li>
    <li><strong>City:</strong> <?php echo $team['city']; ?></li>
    <li><strong>Founded Year:</strong> <?php echo $team['founded_year']; ?></li>
    <!-- Ďalšie informácie o tíme, ktoré môžete pridať -->
</ul>

<a href="teams.php">Back to Teams</a>

</body>
</html>