<?php
require_once 'c:/xampp/htdocs/Portfolio_Builder/config/database.php';

$stmt = $pdo->query("SELECT id, name, slug FROM templates WHERE id > 20");
$templates = $stmt->fetchAll();

foreach ($templates as $t) {
    $width = 400;
    $height = 300;
    $image = imagecreatetruecolor($width, $height);
    
    // Generate some random but nice colors
    $r1 = rand(200, 255); $g1 = rand(200, 255); $b1 = rand(200, 255);
    $r2 = rand(100, 200); $g2 = rand(100, 200); $b2 = rand(100, 200);
    
    for($y=0; $y<$height; $y++) {
        $r = $r1 - (($r1-$r2) * ($y/$height));
        $g = $g1 - (($g1-$g2) * ($y/$height));
        $b = $b1 - (($b1-$b2) * ($y/$height));
        $color = imagecolorallocate($image, $r, $g, $b);
        imageline($image, 0, $y, $width, $y, $color);
    }
    
    $textColor = imagecolorallocate($image, 30, 30, 30);
    $fontPath = 'c:/windows/fonts/arial.ttf';
    
    // Fallback if font missing
    if (file_exists($fontPath)) {
        $text = strtoupper($t['name']);
        $bbox = imagettfbbox(20, 0, $fontPath, $text);
        $textWidth = $bbox[2] - $bbox[0];
        $x = ($width - $textWidth) / 2;
        imagettftext($image, 20, 0, $x, $height / 2, $textColor, $fontPath, $text);
    } else {
        imagestring($image, 5, 50, 140, strtoupper($t['name']), $textColor);
    }
    
    $dest = "c:/xampp/htdocs/Portfolio_Builder/assets/images/uploads/templates/" . $t['slug'] . ".png";
    imagepng($image, $dest);
    imagedestroy($image);
}
echo "Proper images generated for templates 21-50.";
?>
