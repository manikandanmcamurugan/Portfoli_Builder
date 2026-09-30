<?php
require_once 'c:/xampp/htdocs/Portfolio_Builder/config/database.php';

$stmt = $pdo->query("SELECT id, slug FROM templates WHERE id > 20");
$new_templates = $stmt->fetchAll();

$stmt = $pdo->query("SELECT preview_image FROM templates WHERE id <= 20");
$existing_images = $stmt->fetchAll(PDO::FETCH_COLUMN);

$i = 0;
foreach ($new_templates as $t) {
    $source = "c:/xampp/htdocs/Portfolio_Builder/assets/images/templates/" . $existing_images[$i % count($existing_images)];
    $dest = "c:/xampp/htdocs/Portfolio_Builder/assets/images/templates/" . $t['slug'] . ".png";
    
    if (file_exists($source)) {
        copy($source, $dest);
    }
    $i++;
}
echo "Images mapped for templates 21-50.";
?>
