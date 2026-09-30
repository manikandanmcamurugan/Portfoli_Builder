<?php
require_once 'c:/xampp/htdocs/Portfolio_Builder/config/database.php';

$updates = [
    31 => ['name' => 'Cyberpunk Hacker', 'desc' => 'Neon aesthetics for cybersecurity and gamers.'],
    32 => ['name' => 'Medical Care', 'desc' => 'Clean, professional theme for doctors and nurses.'],
    33 => ['name' => 'Legal Firm', 'desc' => 'Corporate and trustworthy for lawyers and consultants.'],
    34 => ['name' => 'Architectural', 'desc' => 'Structured and modern for architects and real estate.'],
    35 => ['name' => 'Photography Lens', 'desc' => 'Visual-heavy layout for photographers and creatives.'],
    36 => ['name' => 'Culinary Arts', 'desc' => 'Warm and appetizing for chefs and restaurants.'],
    37 => ['name' => 'Music Studio', 'desc' => 'Dynamic layout for musicians and audio producers.'],
    38 => ['name' => 'Fitness Trainer', 'desc' => 'High-energy design for sports and personal trainers.'],
    39 => ['name' => 'Fashion Stylist', 'desc' => 'Elegant and chic for models and beauty experts.'],
    40 => ['name' => 'Academic Scholar', 'desc' => 'Classic and organized for teachers and professors.'],
    41 => ['name' => 'Financial Advisor', 'desc' => 'Secure and data-driven for bankers and accountants.'],
    42 => ['name' => 'Eco Nature', 'desc' => 'Green and sustainable for environmentalists.'],
    43 => ['name' => 'Astro Space', 'desc' => 'Dark and expansive for scientists and astronomy.'],
    44 => ['name' => 'Travel Guide', 'desc' => 'Bright and adventurous for travel bloggers.'],
    45 => ['name' => 'Auto Mechanic', 'desc' => 'Industrial and bold for automotive engineers.'],
    46 => ['name' => 'Digital Marketing', 'desc' => 'Conversion-focused for SEO agencies and marketers.'],
    47 => ['name' => 'Event Planner', 'desc' => 'Festive and organized for event coordinators.'],
    48 => ['name' => 'Journalist Writer', 'desc' => 'Text-focused and readable for authors and reporters.'],
    49 => ['name' => 'Esports Streamer', 'desc' => 'Aggressive dark mode for gaming content creators.'],
    50 => ['name' => 'AI Robotics', 'desc' => 'Futuristic and sleek for machine learning engineers.']
];

foreach ($updates as $id => $u) {
    $stmt = $pdo->prepare("UPDATE templates SET name = ?, description = ? WHERE id = ?");
    $stmt->execute([$u['name'], $u['desc'], $id]);
}
echo "Database updated for templates 31-50.";
?>
