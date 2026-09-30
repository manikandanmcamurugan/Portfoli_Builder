<?php
header('Cache-Control: no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

require_once '../includes/student_auth.php';
require_once '../config/database.php';

$stmt = $pdo->prepare("SELECT * FROM profiles WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$profile = $stmt->fetch();

$page_title = $page_title ?? 'Dashboard';

$stmt_set = $pdo->prepare("SELECT portfolio_slug FROM portfolio_settings WHERE user_id = ?");
$stmt_set->execute([$_SESSION['user_id']]);
$slug = $stmt_set->fetchColumn();
$portfolio_url = $slug ? "http://localhost/Portfolio_Builder/portfolio/view.php?user=" . $slug : "#";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> - Portfolio Builder</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <i class="fas fa-layer-group"></i>
                <h2>Portfolio<span style="color: var(--primary);">Builder</span></h2>
            </div>
            <nav class="sidebar-nav">
                <a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"><i class="fas fa-home"></i> Dashboard</a>
                <a href="profile.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>"><i class="fas fa-user"></i> My Profile</a>
                <a href="skills.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'skills.php' ? 'active' : ''; ?>"><i class="fas fa-star"></i> Skills</a>
                <a href="education.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'education.php' ? 'active' : ''; ?>"><i class="fas fa-graduation-cap"></i> Education</a>
                <a href="projects.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'projects.php' ? 'active' : ''; ?>"><i class="fas fa-project-diagram"></i> Projects</a>
                <a href="certificates.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'certificates.php' ? 'active' : ''; ?>"><i class="fas fa-certificate"></i> Certificates</a>
                <a href="internships.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'internships.php' ? 'active' : ''; ?>"><i class="fas fa-briefcase"></i> Internships</a>
                <a href="hackathons.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'hackathons.php' ? 'active' : ''; ?>"><i class="fas fa-code"></i> Hackathons</a>
                <a href="achievements.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'achievements.php' ? 'active' : ''; ?>"><i class="fas fa-trophy"></i> Achievements</a>
                <a href="resume.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'resume.php' ? 'active' : ''; ?>"><i class="fas fa-file-pdf"></i> Resume</a>
                <a href="templates.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'templates.php' ? 'active' : ''; ?>"><i class="fas fa-paint-brush"></i> Templates</a>
                <a href="preview.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'preview.php' ? 'active' : ''; ?>"><i class="fas fa-eye"></i> Preview</a>
                <a href="settings.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>"><i class="fas fa-cog"></i> Settings</a>
                <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <header class="top-header">
                <div class="menu-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')">
                    <i class="fas fa-bars"></i>
                </div>
                
                <div class="header-left">
                    <!-- Space for future breadcrumbs -->
                </div>
                
                <div class="header-right">
                    <div class="search-bar">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search dashboard...">
                    </div>
                    
                    <div class="notifications">
                        <i class="far fa-bell"></i>
                    </div>
                    
                    <div class="user-info">
                        <?php if(!empty($profile['profile_photo'])): ?>
                            <img src="../assets/images/uploads/profile/<?php echo htmlspecialchars($profile['profile_photo']); ?>" alt="Profile" class="avatar">
                        <?php else: ?>
                            <div class="avatar-placeholder"><?php echo strtoupper(substr($_SESSION['name'], 0, 1)); ?></div>
                        <?php endif; ?>
                        
                        <span><?php echo htmlspecialchars($_SESSION['name']); ?></span>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                        
                        <div class="profile-dropdown">
                            <a href="profile.php"><i class="far fa-user"></i> My Profile</a>
                            <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
                            <a href="<?php echo $portfolio_url; ?>" target="_blank"><i class="far fa-eye"></i> View Portfolio</a>
                            <div class="divider"></div>
                            <a href="../logout.php" class="text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </header>
            <div class="content-wrapper">






