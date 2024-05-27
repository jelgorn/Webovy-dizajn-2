<?php
session_start();
include 'config.php';

// Funkce na odstranění zápasu
if (isset($_GET['delete_match'])) {
    $matchId = $_GET['delete_match'];
    
    // Příprava SQL dotazu pro odstranění zápasu
    $sqlDeleteMatch = "DELETE FROM matches WHERE id = ?";
    
    // Příprava a provedení připraveného dotazu
    if ($stmt = $conn->prepare($sqlDeleteMatch)) {
        // Vázání parametrů
        $stmt->bind_param("i", $matchId);
        
        // Provedení dotazu
        if ($stmt->execute()) {
            echo "Zápas byl úspěšně odstraněn.";
        } else {
            echo "Chyba při odstraňování zápasu: " . $stmt->error;
        }
        
        // Uzavření přípraveného dotazu
        $stmt->close();
    } else {
        echo "Chyba při přípravě dotazu: " . $conn->error;
    }
}

// Kontrola, zda je uživatel přihlášen a byl odeslán formulář pro přidání zápasu
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['username'])) {
    $homeTeam = $_POST['home_team'];
    $awayTeam = $_POST['away_team'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Příprava SQL dotazu pro přidání nového zápasu
    $sql = "INSERT INTO matches (home_team, away_team, match_date, match_time) 
            VALUES ('$homeTeam', '$awayTeam', '$date', '$time')";

    if ($conn->query($sql) === TRUE) {
        echo "Zápas byl úspěšně přidán.";
    } else {
        echo "Chyba při přidávání zápasu: " . $conn->error;
    }
}

// Dotaz na všechny týmy
$sqlTeams = "SELECT * FROM teams";
$resultTeams = $conn->query($sqlTeams);
$teams = [];

if ($resultTeams->num_rows > 0) {
    while ($row = $resultTeams->fetch_assoc()) {
        $teams[] = $row;
    }
}

// Dotaz na všechny zápasy
$sqlMatches = "SELECT * FROM matches";
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
    <title>Manage Matches</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        form {
            background: #fff;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        select, input[type="date"], input[type="time"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            display: inline-block;
            color: #fff;
            background: #0779e4;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #0056b3;
        }
        ul {list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
        .match {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .delete-button {
            color: #fff;
            background-color: #ff0000;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <h1>Manage Matches</h1>
    </header>
    <div class="container">
        <!-- Formulár pre pridanie zápasu -->
        <form method="post" action="">
            <label for="home_team">Home Team</label>
            <select id="home_team" name="home_team" required>
                <option value="" disabled selected>Select Home Team</option>
                <?php foreach ($teams as $team): ?>
                    <option value="<?php echo $team['id']; ?>"><?php echo htmlspecialchars($team['name']); ?></option>
                <?php endforeach; ?>
            </select>
            
            <label for="away_team">Away Team</label>
            <select id="away_team" name="away_team" required>
                <option value="" disabled selected>Select Away Team</option>
                <?php foreach ($teams as $team): ?>
                    <option value="<?php echo $team['id']; ?>"><?php echo htmlspecialchars($team['name']); ?></option>
                <?php endforeach; ?>
            </select>
            
            <label for="date">Date</label>
            <input type="date" id="date" name="date" required>
            
            <label for="time">Time</label>
            <input type="time" id="time" name="time" required>
            
            <input type="submit" value="Add Match">
        </form>
        
        <!-- Zoznam zápasov -->
        <h2>Matches</h2>
<ul>
    <?php foreach ($matches as $match): ?>
    <div class="match">
        <p><?php echo htmlspecialchars($match['match_date']); ?></p>
        <p><?php echo htmlspecialchars($match['match_time']); ?></p>
        <div class="team-names">
            <?php
                // Dotaz na názvy domácího a hostujícího týmu na základě jejich ID
                $homeTeamId = $match['home_team'];
                $awayTeamId = $match['away_team'];
                
                $sqlHomeTeam = "SELECT name FROM teams WHERE id = $homeTeamId";
                $sqlAwayTeam = "SELECT name FROM teams WHERE id = $awayTeamId";
                
                $resultHomeTeam = $conn->query($sqlHomeTeam);
                $resultAwayTeam = $conn->query($sqlAwayTeam);
                
                if ($resultHomeTeam && $resultAwayTeam) {
                    $homeTeamName = $resultHomeTeam->fetch_assoc()['name'];
                    $awayTeamName = $resultAwayTeam->fetch_assoc()['name'];
                    
                    echo "<p>$homeTeamName : $awayTeamName</p>";
                } else {
                    echo "Chyba při získávání informací o týmu.";
                }
            ?>
        </div>
        <!-- Tlačítko pro odstranění zápasu -->
        <form method="get" action="">
            <input type="hidden" name="delete_match" value="<?php echo $match['id']; ?>">
            <button type="submit" class="delete-button">Delete Match</button>
        </form>
    </div>
    <?php endforeach; ?>
</ul>
    </div>
</body>
</html>

