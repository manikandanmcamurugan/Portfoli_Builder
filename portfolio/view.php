<?php
require_once '../config/database.php';

$slug = $_GET['user'] ?? null;
if (!$slug) die("Portfolio not found.");

// Start session to check if user is logged in (for preview)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$logged_in_user_id = $_SESSION['user_id'] ?? null;

// Get portfolio settings
$stmt = $pdo->prepare("SELECT * FROM portfolio_settings WHERE portfolio_slug = ?");
$stmt->execute([$slug]);
$settings = $stmt->fetch();

if (!$settings) {
    die("Portfolio not found.");
}

// Check if portfolio is private and the logged in user is not the owner
if (!$settings['is_published'] && $settings['user_id'] != $logged_in_user_id) {
    die("Portfolio not found or is currently private.");
}

$user_id = $settings['user_id'];
$template_id = $settings['template_id'];

if (!$template_id) die("No template selected for this portfolio.");

// Get template file
$stmt = $pdo->prepare("SELECT template_file FROM templates WHERE id = ?");
$stmt->execute([$template_id]);
$template_file = $stmt->fetchColumn();

if (!$template_file || !file_exists('../templates/' . $template_file)) {
    die("Template file is missing.");
}

// Fetch all user data for the template
$stmt = $pdo->prepare("SELECT * FROM profiles WHERE user_id = ?"); $stmt->execute([$user_id]); $profile = $stmt->fetch();
$stmt = $pdo->prepare("SELECT * FROM skills WHERE user_id = ?"); $stmt->execute([$user_id]); $skills = $stmt->fetchAll();
$stmt = $pdo->prepare("SELECT * FROM projects WHERE user_id = ?"); $stmt->execute([$user_id]); $projects = $stmt->fetchAll();

// Fetch additional data
$stmt = $pdo->prepare("SELECT * FROM education WHERE user_id = ? ORDER BY end_year DESC"); $stmt->execute([$user_id]); $education = $stmt->fetchAll();
$stmt = $pdo->prepare("SELECT * FROM certificates WHERE user_id = ? ORDER BY issue_date DESC"); $stmt->execute([$user_id]); $certificates = $stmt->fetchAll();
$stmt = $pdo->prepare("SELECT * FROM internships WHERE user_id = ? ORDER BY end_date DESC"); $stmt->execute([$user_id]); $internships = $stmt->fetchAll();
$stmt = $pdo->prepare("SELECT * FROM hackathons WHERE user_id = ? ORDER BY date DESC"); $stmt->execute([$user_id]); $hackathons = $stmt->fetchAll();
$stmt = $pdo->prepare("SELECT * FROM achievements WHERE user_id = ?"); $stmt->execute([$user_id]); $achievements = $stmt->fetchAll();
$stmt = $pdo->prepare("SELECT * FROM resumes WHERE user_id = ?"); $stmt->execute([$user_id]); $resume = $stmt->fetch();

// Include the template, which will use the $profile, $skills, etc. variables
require_once '../templates/' . $template_file;
?>


