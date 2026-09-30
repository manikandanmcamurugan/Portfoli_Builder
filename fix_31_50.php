<?php
require_once 'c:/xampp/htdocs/Portfolio_Builder/config/database.php';
$stmt = $pdo->query('SELECT id, name, slug FROM templates WHERE id >= 31');
$templates = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($templates as $t) {
    $text = urlencode($t['name']);
    // Generate random background color
    $r = rand(10, 50); $g = rand(10, 50); $b = rand(10, 50);
    $bg = sprintf("%02x%02x%02x", $r, $g, $b);
    // Generate contrasting text color
    $fg = "ffffff";
    
    $url = "https://placehold.co/400x300/$bg/$fg.png?text=$text";
    $dest = "c:/xampp/htdocs/Portfolio_Builder/assets/images/uploads/templates/" . $t['slug'] . ".png";
    
    // Download using file_get_contents since allow_url_fopen is usually on
    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0\r\n"
        ]
    ];
    $context = stream_context_create($opts);
    $image = file_get_contents($url, false, $context);
    if ($image) {
        file_put_contents($dest, $image);
    }
}
echo "Downloaded correct images for 31-50.";
