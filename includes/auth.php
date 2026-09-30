<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['logged_in']);
}

function getUserRole() {
    return isset($_SESSION['role']) ? $_SESSION['role'] : null;
}

function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header("Location: ../login.php");
        exit;
    }
}
?>
