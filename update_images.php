<?php
require_once 'c:/xampp/htdocs/Portfolio_Builder/config/database.php';
$pdo->exec("UPDATE templates SET preview_image = CONCAT(slug, '.png')");
echo 'Updated db.';
