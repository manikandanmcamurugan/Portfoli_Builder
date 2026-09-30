<?php
session_start();
require_once '../includes/auth.php';
redirectIfNotLoggedIn();
require_once '../config/database.php';

$user_id = $_SESSION['user_id'];

// Fetch all data
$stmt = $pdo->prepare("SELECT * FROM profiles WHERE user_id = ?"); $stmt->execute([$user_id]); $profile = $stmt->fetch();
$stmt = $pdo->prepare("SELECT * FROM education WHERE user_id = ? ORDER BY end_year DESC"); $stmt->execute([$user_id]); $education = $stmt->fetchAll();
$stmt = $pdo->prepare("SELECT * FROM skills WHERE user_id = ?"); $stmt->execute([$user_id]); $skills = $stmt->fetchAll();
$stmt = $pdo->prepare("SELECT * FROM projects WHERE user_id = ?"); $stmt->execute([$user_id]); $projects = $stmt->fetchAll();
$stmt = $pdo->prepare("SELECT * FROM internships WHERE user_id = ? ORDER BY end_date DESC"); $stmt->execute([$user_id]); $internships = $stmt->fetchAll();
$stmt = $pdo->prepare("SELECT * FROM hackathons WHERE user_id = ? ORDER BY date DESC"); $stmt->execute([$user_id]); $hackathons = $stmt->fetchAll();
$stmt = $pdo->prepare("SELECT * FROM certificates WHERE user_id = ? ORDER BY issue_date DESC"); $stmt->execute([$user_id]); $certificates = $stmt->fetchAll();
$stmt = $pdo->prepare("SELECT * FROM achievements WHERE user_id = ?"); $stmt->execute([$user_id]); $achievements = $stmt->fetchAll();

if (!$profile) {
    die("Please complete your profile first.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($profile['full_name']); ?> - Resume</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; color: #333; line-height: 1.6; margin: 0; padding: 0; background: #f4f7f6; }
        .resume-container { max-width: 800px; margin: 40px auto; background: #fff; padding: 50px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        h1 { margin: 0; font-size: 36px; color: #111; }
        h2 { font-size: 18px; text-transform: uppercase; border-bottom: 2px solid #333; padding-bottom: 5px; margin-top: 30px; margin-bottom: 15px; color: #111; }
        .contact-info { display: flex; flex-wrap: wrap; gap: 15px; margin-top: 10px; font-size: 14px; color: #555; }
        .contact-info div { display: flex; align-items: center; gap: 5px; }
        .section-item { margin-bottom: 15px; }
        .section-item h3 { margin: 0; font-size: 16px; color: #222; display: flex; justify-content: space-between; }
        .section-item h3 span { font-weight: normal; font-size: 14px; color: #666; }
        .section-item h4 { margin: 2px 0 5px 0; font-size: 15px; color: #444; font-weight: 500; }
        .section-item p { margin: 0; font-size: 14px; color: #555; }
        .skills-list { display: flex; flex-wrap: wrap; gap: 10px; margin: 0; padding: 0; list-style: none; }
        .skills-list li { background: #eee; padding: 4px 10px; border-radius: 4px; font-size: 13px; font-weight: 500; color: #333; }
        .btn-print { display: block; width: 200px; margin: 20px auto; padding: 12px; background: #007bff; color: #fff; text-align: center; border-radius: 5px; text-decoration: none; font-weight: bold; cursor: pointer; border: none; font-size: 16px; }
        .btn-print:hover { background: #0056b3; }
        @media print {
            body { background: #fff; }
            .resume-container { box-shadow: none; margin: 0; padding: 0; max-width: 100%; }
            .btn-print { display: none; }
            @page { margin: 2cm; }
        }
    </style>
</head>
<body>

<button class="btn-print" onclick="window.print()"><i class="fas fa-print"></i> Print / Save as PDF</button>

<div class="resume-container">
    <header>
        <h1><?php echo htmlspecialchars($profile['full_name']); ?></h1>
        <div style="font-size: 18px; color: #555; margin-top: 5px; font-weight: 500;"><?php echo htmlspecialchars($profile['headline'] ?? ''); ?></div>
        
        <div class="contact-info">
            <?php if(!empty($profile['location'])): ?><div><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($profile['location']); ?></div><?php endif; ?>
            <?php if(!empty($profile['phone'])): ?><div><i class="fas fa-phone"></i> <?php echo htmlspecialchars($profile['phone']); ?></div><?php endif; ?>
            <?php if(!empty($_SESSION['email'])): ?><div><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?></div><?php endif; ?>
            <?php if(!empty($profile['linkedin'])): ?><div><i class="fab fa-linkedin"></i> <?php echo htmlspecialchars(str_replace('https://', '', $profile['linkedin'])); ?></div><?php endif; ?>
            <?php if(!empty($profile['github'])): ?><div><i class="fab fa-github"></i> <?php echo htmlspecialchars(str_replace('https://', '', $profile['github'])); ?></div><?php endif; ?>
        </div>
    </header>

    <?php if(!empty($profile['about'])): ?>
    <section>
        <h2>Professional Summary</h2>
        <p style="font-size: 14px;"><?php echo nl2br(htmlspecialchars($profile['about'])); ?></p>
    </section>
    <?php endif; ?>

    <?php if(!empty($education)): ?>
    <section>
        <h2>Education</h2>
        <?php foreach($education as $e): ?>
        <div class="section-item">
            <h3><?php echo htmlspecialchars($e['degree']); ?> <span><?php echo htmlspecialchars($e['start_year'] ?? '') . ' - ' . htmlspecialchars($e['end_year']); ?></span></h3>
            <h4><?php echo htmlspecialchars($e['college']); ?></h4>
            <?php if(!empty($e['description'])): ?><p><?php echo htmlspecialchars($e['description']); ?></p><?php endif; ?>
        </div>
        <?php endforeach; ?>
    </section>
    <?php endif; ?>

    <?php if(!empty($internships)): ?>
    <section>
        <h2>Experience</h2>
        <?php foreach($internships as $i): ?>
        <div class="section-item">
            <h3><?php echo htmlspecialchars($i['role']); ?> <span><?php echo htmlspecialchars($i['start_date']) . ' to ' . htmlspecialchars($i['end_date']); ?></span></h3>
            <h4><?php echo htmlspecialchars($i['company']); ?></h4>
            <p><?php echo nl2br(htmlspecialchars($i['description'])); ?></p>
        </div>
        <?php endforeach; ?>
    </section>
    <?php endif; ?>

    <?php if(!empty($projects)): ?>
    <section>
        <h2>Projects</h2>
        <?php foreach($projects as $p): ?>
        <div class="section-item">
            <h3><?php echo htmlspecialchars($p['title']); ?> <span><?php echo htmlspecialchars($p['technologies']); ?></span></h3>
            <p><?php echo nl2br(htmlspecialchars($p['description'])); ?></p>
        </div>
        <?php endforeach; ?>
    </section>
    <?php endif; ?>

    <?php if(!empty($skills)): ?>
    <section>
        <h2>Skills</h2>
        <ul class="skills-list">
            <?php foreach($skills as $s): ?>
            <li><?php echo htmlspecialchars($s['skill_name']); ?></li>
            <?php endforeach; ?>
        </ul>
    </section>
    <?php endif; ?>

    <?php if(!empty($hackathons)): ?>
    <section>
        <h2>Hackathons</h2>
        <?php foreach($hackathons as $h): ?>
        <div class="section-item">
            <h3><?php echo htmlspecialchars($h['hackathon_name']); ?> <span><?php echo htmlspecialchars($h['date']); ?></span></h3>
            <h4><?php echo htmlspecialchars($h['project_title']); ?></h4>
            <p><?php echo htmlspecialchars($h['description']); ?></p>
        </div>
        <?php endforeach; ?>
    </section>
    <?php endif; ?>

    <?php if(!empty($certificates) || !empty($achievements)): ?>
    <section>
        <h2>Certifications & Achievements</h2>
        <?php foreach($certificates as $c): ?>
        <div class="section-item">
            <h3><?php echo htmlspecialchars($c['title']); ?> <span><?php echo htmlspecialchars($c['issue_date']); ?></span></h3>
            <h4><?php echo htmlspecialchars($c['issuer']); ?></h4>
        </div>
        <?php endforeach; ?>
        <?php foreach($achievements as $a): ?>
        <div class="section-item">
            <h3><?php echo htmlspecialchars($a['title']); ?></h3>
            <h4><?php echo htmlspecialchars($a['issuer']); ?></h4>
        </div>
        <?php endforeach; ?>
    </section>
    <?php endif; ?>

</div>
</body>
</html>
