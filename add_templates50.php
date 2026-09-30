<?php
require_once 'c:/xampp/htdocs/Portfolio_Builder/config/database.php';

$new_templates = [
    21 => ['name' => 'Crimson Code', 'desc' => 'A bold dark theme with deep crimson accents.', 'c1' => '#000000', 'c2' => '#dc143c', 'slug' => 'crimson-code', 'type' => 'dark'],
    22 => ['name' => 'Aqua Marine', 'desc' => 'Fresh and light with teal and aquamarine.', 'c1' => '#ffffff', 'c2' => '#20b2aa', 'slug' => 'aqua-marine', 'type' => 'light'],
    23 => ['name' => 'Purple Rain', 'desc' => 'A moody purple gradient for creatives.', 'c1' => '#1e1025', 'c2' => '#9370db', 'slug' => 'purple-rain', 'type' => 'dark'],
    24 => ['name' => 'Solar Flare', 'desc' => 'Bright yellow and orange energetic layout.', 'c1' => '#fffdf0', 'c2' => '#ff8c00', 'slug' => 'solar-flare', 'type' => 'light'],
    25 => ['name' => 'Midnight Blue', 'desc' => 'Professional dark blue corporate feel.', 'c1' => '#0a192f', 'c2' => '#64ffda', 'slug' => 'midnight-blue', 'type' => 'dark'],
    26 => ['name' => 'Cherry Blossom', 'desc' => 'Soft pinks and warm whites for designers.', 'c1' => '#fff0f5', 'c2' => '#ffb7c5', 'slug' => 'cherry-blossom', 'type' => 'light'],
    27 => ['name' => 'Slate Grey', 'desc' => 'Minimalist industrial dark theme.', 'c1' => '#2f4f4f', 'c2' => '#778899', 'slug' => 'slate-grey', 'type' => 'dark'],
    28 => ['name' => 'Golden Hour', 'desc' => 'Warm sunset tones over a light background.', 'c1' => '#fafad2', 'c2' => '#daa520', 'slug' => 'golden-hour', 'type' => 'light'],
    29 => ['name' => 'Emerald City', 'desc' => 'Deep greens for a natural, grounded vibe.', 'c1' => '#002910', 'c2' => '#50c878', 'slug' => 'emerald-city', 'type' => 'dark'],
    30 => ['name' => 'Ice Cold', 'desc' => 'Crisp whites and frosty light blues.', 'c1' => '#f0ffff', 'c2' => '#add8e6', 'slug' => 'ice-cold', 'type' => 'light'],
    31 => ['name' => 'Neon Pink', 'desc' => 'Cyberpunk aesthetics with bright pinks.', 'c1' => '#0d0d0d', 'c2' => '#ff1493', 'slug' => 'neon-pink', 'type' => 'dark'],
    32 => ['name' => 'Classic Red', 'desc' => 'A traditional, powerful red and white layout.', 'c1' => '#ffffff', 'c2' => '#b22222', 'slug' => 'classic-red', 'type' => 'light'],
    33 => ['name' => 'Space Nebula', 'desc' => 'Galactic purples and blacks.', 'c1' => '#0f0518', 'c2' => '#ba55d3', 'slug' => 'space-nebula', 'type' => 'dark'],
    34 => ['name' => 'Minty Fresh', 'desc' => 'Clean and energetic mint greens.', 'c1' => '#f5fffa', 'c2' => '#00ff7f', 'slug' => 'minty-fresh', 'type' => 'light'],
    35 => ['name' => 'Graphite', 'desc' => 'Serious and professional dark grey palette.', 'c1' => '#1c1c1c', 'c2' => '#9e9e9e', 'slug' => 'graphite', 'type' => 'dark'],
    36 => ['name' => 'Peach Perfect', 'desc' => 'Warm, soft, and inviting.', 'c1' => '#fff5ee', 'c2' => '#ffdab9', 'slug' => 'peach-perfect', 'type' => 'light'],
    37 => ['name' => 'Deep Ocean', 'desc' => 'Abyssal blues for a serious coder look.', 'c1' => '#00008b', 'c2' => '#4169e1', 'slug' => 'deep-ocean', 'type' => 'dark'],
    38 => ['name' => 'Citrus Splash', 'desc' => 'Vibrant orange and lemon accents.', 'c1' => '#ffffff', 'c2' => '#ff8c00', 'slug' => 'citrus-splash', 'type' => 'light'],
    39 => ['name' => 'Ruby Red', 'desc' => 'Dark and luxurious ruby accents.', 'c1' => '#1a0000', 'c2' => '#e0115f', 'slug' => 'ruby-red', 'type' => 'dark'],
    40 => ['name' => 'Lavender Dream', 'desc' => 'Calming light purples.', 'c1' => '#f8f8ff', 'c2' => '#e6e6fa', 'slug' => 'lavender-dream', 'type' => 'light'],
    41 => ['name' => 'Cyber Yellow', 'desc' => 'High contrast black and electric yellow.', 'c1' => '#000000', 'c2' => '#ffd700', 'slug' => 'cyber-yellow', 'type' => 'dark'],
    42 => ['name' => 'Coral Reef', 'desc' => 'Bright whites with beautiful coral accents.', 'c1' => '#ffffff', 'c2' => '#ff7f50', 'slug' => 'coral-reef', 'type' => 'light'],
    43 => ['name' => 'Olive Branch', 'desc' => 'Earthy and grounded dark olive tones.', 'c1' => '#191c13', 'c2' => '#6b8e23', 'slug' => 'olive-branch', 'type' => 'dark'],
    44 => ['name' => 'Cotton Candy', 'desc' => 'Fun and creative pinks and light blues.', 'c1' => '#ffffff', 'c2' => '#ffb6c1', 'slug' => 'cotton-candy', 'type' => 'light'],
    45 => ['name' => 'Dark Chocolate', 'desc' => 'Rich, warm brown tones.', 'c1' => '#2b1b17', 'c2' => '#d2691e', 'slug' => 'dark-chocolate', 'type' => 'dark'],
    46 => ['name' => 'Sky High', 'desc' => 'Airy light blues on pure white.', 'c1' => '#ffffff', 'c2' => '#87ceeb', 'slug' => 'sky-high', 'type' => 'light'],
    47 => ['name' => 'Amethyst', 'desc' => 'Rich gemstone purples in a dark setting.', 'c1' => '#1a1124', 'c2' => '#9966cc', 'slug' => 'amethyst', 'type' => 'dark'],
    48 => ['name' => 'Matcha Green', 'desc' => 'Organic and healthy green tones.', 'c1' => '#fdf5e6', 'c2' => '#90ee90', 'slug' => 'matcha-green', 'type' => 'light'],
    49 => ['name' => 'Volcano', 'desc' => 'Charcoal greys with fiery magma red accents.', 'c1' => '#212121', 'c2' => '#ff4500', 'slug' => 'volcano', 'type' => 'dark'],
    50 => ['name' => 'Pure White', 'desc' => 'Ultra minimalist pure white with stark black text.', 'c1' => '#ffffff', 'c2' => '#000000', 'slug' => 'pure-white', 'type' => 'light'],
];

$base = file_get_contents('c:/xampp/htdocs/Portfolio_Builder/templates/template1.php');

foreach ($new_templates as $id => $t) {
    // 1. Insert into DB
    $stmt = $pdo->prepare("SELECT id FROM templates WHERE slug = ?");
    $stmt->execute([$t['slug']]);
    if (!$stmt->fetch()) {
        $ins = $pdo->prepare("INSERT INTO templates (name, description, template_file, preview_image, slug) VALUES (?, ?, ?, ?, ?)");
        $ins->execute([$t['name'], $t['desc'], "template$id.php", $t['slug'].'.png', $t['slug']]);
    }
    
    // 2. Generate template file
    $bg = $t['type'] == 'dark' ? $t['c1'] : '#ffffff';
    $text = $t['type'] == 'dark' ? '#eeeeee' : '#333333';
    $primary = $t['c2'];
    $card_bg = $t['type'] == 'dark' ? 'rgba(255,255,255,0.05)' : '#f9f9f9';
    
    $custom_css = "<style>
    :root {
        --primary-color: $primary;
        --secondary-color: $primary;
        --text-color: $text;
        --bg-color: $bg;
    }
    body { background-color: var(--bg-color); color: var(--text-color); }
    .card { background-color: $card_bg !important; }
    header, footer { background-color: $card_bg !important; border-color: $primary !important; }
    </style>";
    
    $new_content = str_replace('</head>', $custom_css . "\n</head>", $base);
    file_put_contents("c:/xampp/htdocs/Portfolio_Builder/templates/template$id.php", $new_content);
}
echo "Templates 21-50 created.";
?>
