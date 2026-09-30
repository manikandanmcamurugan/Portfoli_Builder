<?php
require_once 'auth.php';

redirectIfNotLoggedIn();

if (getUserRole() !== 'student') {
    header("Location: ../login.php");
    exit;
}
?>
