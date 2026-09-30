<?php
require_once 'c:/xampp/htdocs/Portfolio_Builder/config/database.php';
$pdo->exec("INSERT IGNORE INTO templates (name, slug, description, template_file) VALUES 
    ('Corporate Blue', 'corp-blue', 'A clean layout featuring corporate blue branding.', 'template6.php'),
    ('Neon Cyber', 'neon-cyber', 'A cyberpunk inspired dark theme.', 'template7.php'),
    ('Elegant Serif', 'elegant-serif', 'A classy theme using serif typography for writers and artists.', 'template8.php'),
    ('Forest Green', 'forest-green', 'A calming, nature-inspired green layout.', 'template9.php'),
    ('Sunset Orange', 'sunset-orange', 'A warm, gradient-heavy design.', 'template10.php')
");
echo 'Templates 6-10 added to database.';
