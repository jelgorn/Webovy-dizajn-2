<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Ak užívateľ nie je prihlásený, presmeruje ho na prihlasovaciu stránku
    exit();
}
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $team_id = $_GET['id'];
    $sql = "SELECT * FROM teams WHERE id = $team_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Tu zobrazíme informácie o tíme a umožníme užívateľovi ich upravovať
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Team Info</title>
</head>
<body>
    <h2>Edit Team Information</h2>
    <form action="update_team.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="name">Team Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>"><br>
        <label for="city">City:</label><br>
        <input type="text" id="city" name="city" value="<?php echo $row['city']; ?>"><br>
        <label for="founded_year">Founded Year:</label><br>
        <input type="number" id="founded_year" name="founded_year" value="<?php echo $row['founded_year']; ?>"><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
<?php
    } else {
        echo "Team not found";
    }
} else {
    echo "Invalid request";
}
$conn->close();
?>
