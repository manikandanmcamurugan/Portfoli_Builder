<?php
require_once 'c:/xampp/htdocs/Portfolio_Builder/config/database.php';
$pdo->exec("INSERT IGNORE INTO templates (name, slug, description, template_file) VALUES 
    ('Creative', 'creative', 'A vibrant and animated design to showcase creativity.', 'template3.php'),
    ('Minimal', 'minimal', 'A clean, whitespace-heavy design focusing on simplicity.', 'template4.php'),
    ('Developer', 'developer', 'A dark, terminal-inspired UI for programmers.', 'template5.php')
");
echo 'Templates added to database.';
