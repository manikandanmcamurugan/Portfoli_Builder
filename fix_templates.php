<?php
$files = glob('c:/xampp/htdocs/Portfolio_Builder/templates/template*.php');
foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Fix missing variables and wrong columns
    $content = str_replace("htmlspecialchars(\['degree']);", "htmlspecialchars(\['degree'] ?? '');", $content);
    $content = str_replace("htmlspecialchars(\['institution']);", "htmlspecialchars(\['college'] ?? '');", $content);
    $content = str_replace("htmlspecialchars(\['graduation_year']);", "htmlspecialchars(\['end_year'] ?? '');", $content);
    
    $content = str_replace("htmlspecialchars(\['role']);", "htmlspecialchars(\['role'] ?? '');", $content);
    $content = str_replace("htmlspecialchars(\['company']);", "htmlspecialchars(\['company'] ?? '');", $content);
    $content = str_replace("htmlspecialchars(\['start_date']) . ' to ' . htmlspecialchars(\['end_date']);", "htmlspecialchars(\['start_date'] ?? '') . ' to ' . htmlspecialchars(\['end_date'] ?? '');", $content);
    $content = str_replace("htmlspecialchars(\['description']);", "htmlspecialchars(\['description'] ?? '');", $content);
    
    $content = str_replace("htmlspecialchars(\['hackathon_name']);", "htmlspecialchars(\['hackathon_name'] ?? '');", $content);
    $content = str_replace("htmlspecialchars(\['project_title']);", "htmlspecialchars(\['project_title'] ?? '');", $content);
    $content = str_replace("htmlspecialchars(\['date']);", "htmlspecialchars(\['date'] ?? '');", $content);
    
    $content = str_replace("htmlspecialchars(\['title']);", "htmlspecialchars(\['title'] ?? \['title'] ?? '');", $content);
    $content = str_replace("htmlspecialchars(\['issuer']);", "htmlspecialchars(\['issuer'] ?? \['issuer'] ?? '');", $content);
    $content = str_replace("htmlspecialchars(\['issue_date']);", "htmlspecialchars(\['issue_date'] ?? '');", $content);
    $content = str_replace("htmlspecialchars(\['certificate_file']);", "htmlspecialchars(\['certificate_file'] ?? '');", $content);
    
    $content = str_replace("htmlspecialchars(\['file_path']);", "htmlspecialchars(\['file_path'] ?? '');", $content);
    
    file_put_contents($file, $content);
}
echo "Fixed all template syntax errors.";
