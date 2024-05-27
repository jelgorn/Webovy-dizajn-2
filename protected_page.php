<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Chránený obsah tu
echo "Welcome, " . $_SESSION['username'];
?>