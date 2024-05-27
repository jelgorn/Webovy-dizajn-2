<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Prihlásenie úspešné, ulož meno používateľa do session
            session_start();
            $_SESSION['username'] = $row['username'];
            header("Location: index.php");
            exit(); 
        } else {
            echo "Invalid password";
        }
    } else {
        echo "No user found";
    }

    $conn->close();
}
?>

