<?php
require_once 'c:/xampp/htdocs/Portfolio_Builder/config/database.php';
$stmt = $pdo->query('SHOW COLUMNS FROM profiles');
echo json_encode($stmt->fetchAll(PDO::FETCH_COLUMN));
