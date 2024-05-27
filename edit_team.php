<?php
include 'config.php';
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $team_id = $_POST['team_id'];

    if (isset($_POST['name'])) {
        // Úprava tímu
        $name = $_POST['name'];
        $city = $_POST['city'];
        $founded_year = $_POST['founded_year'];

        $stmt = $conn->prepare("UPDATE teams SET name=?, city=?, founded_year=? WHERE id=?");
        $stmt->bind_param("ssii", $name, $city, $founded_year, $team_id);

        if ($stmt->execute()) {
            echo "Team updated successfully";
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Zobrazenie formulára na úpravu tímu
        $stmt = $conn->prepare("SELECT * FROM teams WHERE id=?");
        $stmt->bind_param("i", $team_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Team</title>
</head>
<body>
    <h2>Edit Team</h2>
    <form action="edit_team.php" method="post">
        <input type="hidden" name="team_id" value="<?php echo $team_id; ?>">
        <label for="name">Team Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required><br>
        <label for="city">City:</label>
        <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($row['city']); ?>" required><br>
        <label for="founded_year">Founded Year:</label>
        <input type="number" id="founded_year" name="founded_year" value="<?php echo htmlspecialchars($row['founded_year']); ?>" required><br>
        <button type="submit">Update Team</button>
    </form>
</body>
</html>
<?php
    }
    $conn->close();
} else {
    // Zobrazenie formulára na výber tímu na úpravu
    $sql = "SELECT * FROM teams";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Select Team to Edit</h2>";
        echo "<form action='edit_team.php' method='post'>";
        echo "<select name='team_id'>";
        while($row = $result->fetch_assoc()) {
            echo "<option value='" . htmlspecialchars($row["id"]) . "'>" . htmlspecialchars($row["name"]) . "</option>";
        }
        echo "</select>";
        echo "<button type='submit'>Edit Team</button>";
        echo "</form>";
    } else {
        echo "0 teams";
    }
    $conn->close();
}
?>
