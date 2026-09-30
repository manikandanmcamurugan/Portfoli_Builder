<?php
require_once 'c:/xampp/htdocs/Portfolio_Builder/config/database.php';
$stmt = $pdo->query('SELECT id, name, slug FROM templates WHERE id >= 21');
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
