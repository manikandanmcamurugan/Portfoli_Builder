<?php
require_once 'auth.php';

redirectIfNotLoggedIn();

if (getUserRole() !== 'admin') {
    header("Location: ../login.php");
    exit;
}
?>
