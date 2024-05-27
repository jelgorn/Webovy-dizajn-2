<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $team_id = $_POST['team_id'];

    $sql = "DELETE FROM teams WHERE id=$team_id";

    if ($conn->query($sql) === TRUE) {
        echo "Team deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
} else {
    $sql = "SELECT * FROM teams";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Select Team to Delete</h2>";
        echo "<form action='delete_team.php' method='post'>";
        echo "<select name='team_id'>";
        while($row = $result->fetch_assoc()) {
            echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
        }
        echo "</select>";
        echo "<button type='submit'>Delete Team</button>";
        echo "</form>";
    } else {
        echo "0 teams";
    }
    $conn->close();
}
?>