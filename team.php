<?php
include 'config.php';

// Načítanie tímov z databázy
$sql = "SELECT * FROM teams";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Ak sú tímy k dispozícii, zobrazíme ich
    while($row = $result->fetch_assoc()) {
        // Zobrazenie informácií o tíme
        echo "<div>";
        echo "<p><strong>Team:</strong> " . $row["name"] . "</p>";
        echo "<p><strong>City:</strong> " . $row["city"] . "</p>";
        echo "<p><strong>Founded:</strong> " . $row["founded_year"] . "</p>";
        // Zobrazenie obrázka loga tímu
        echo '<img src="loga/' . $row["id"] . '.png" alt="' . $row["name"] . '" width="50" height="50">';
        echo "</div>";
    }
} else {
    // Ak nie sú žiadne tímy k dispozícii, zobrazíme správu o nulových výsledkoch
    echo "No teams found.";
}

// Zatvorenie spojenia s databázou
$conn->close();
?>
