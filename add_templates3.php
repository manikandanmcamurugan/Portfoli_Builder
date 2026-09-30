<?php
require_once 'c:/xampp/htdocs/Portfolio_Builder/config/database.php';
$pdo->exec("INSERT IGNORE INTO templates (name, slug, description, template_file) VALUES 
    ('Monochrome', 'monochrome', 'A pure black and white high-contrast theme.', 'template11.php'),
    ('Ocean Deep', 'ocean-deep', 'A dark blue underwater aesthetic.', 'template12.php'),
    ('Pastel Dream', 'pastel-dream', 'A soft, cute pastel colored layout.', 'template13.php'),
    ('Retro 80s', 'retro-80s', 'A retro inspired theme with neon highlights.', 'template14.php'),
    ('Midnight Purple', 'midnight-purple', 'A sleek dark purple tech theme.', 'template15.php'),
    ('Hacker', 'hacker', 'A green-on-black terminal theme.', 'template16.php'),
    ('Soft Gold', 'soft-gold', 'A luxurious white and gold aesthetic.', 'template17.php'),
    ('Code Blue', 'code-blue', 'A light blue coding environment style.', 'template18.php'),
    ('Vampire Dark', 'vampire-dark', 'A dark red and black moody theme.', 'template19.php'),
    ('High Visibility', 'high-vis', 'An ultra high-contrast accessibility theme.', 'template20.php')
");
echo 'Templates 11-20 added to database.';
