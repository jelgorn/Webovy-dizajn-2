<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $city = $_POST['city'];
    $founded_year = $_POST['founded_year'];

    $sql = "INSERT INTO teams (name, city, founded_year) VALUES ('$name', '$city', '$founded_year')";

    if ($conn->query($sql) === TRUE) {
        echo "New team added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>