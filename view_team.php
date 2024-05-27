<?php
include 'config.php';
session_start();

// Zabezpečenie prístupu len pre prihlásených užívateľov
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$team_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM teams WHERE id=?");
$stmt->bind_param("i", $team_id);
$stmt->execute();
$result = $stmt->get_result();
$team = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Team</title>
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
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #0779e4 3px solid;
        }
        header a {
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }
        header ul {
            padding: 0;
            list-style: none;
        }
        header li {
            float: left;
            display: inline;
            padding: 0 20px 0 20px;
        }
        footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 30px;
            margin-top: 30px;
        }
        .content {
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1>NHL Management System</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="teams.php">Tímy</a></li>
                    <li><a href="edit_team.php">Manage Teams</a></li>
                    <li><a href="matches.php">View Matches</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="content">
            <h2>Team Details</h2>
            <?php if ($team): ?>
                <p><strong>Team Name:</strong> <?php echo htmlspecialchars($team['name']); ?></p>
                <p><strong>City:</strong> <?php echo htmlspecialchars($team['city']); ?></p>
                <p><strong>Founded Year:</strong> <?php echo htmlspecialchars($team['founded_year']); ?></p>
            <?php else: ?>
                <p>Team not found.</p>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <p>NHL Management System &copy; 2024</p>
    </footer>
</body>
</html>
