<?php
require_once '../includes/admin_auth.php';
require_once '../config/database.php';

$page_title = $page_title ?? 'Admin Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> - Admin - Portfolio Builder</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar { background: #0f172a; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background: #1e293b; border-left: 4px solid #f59e0b; }
        .card-icon { color: #f59e0b; }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin<span style="color: #f59e0b;">Panel</span></h2>
            </div>
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>"><i class="fas fa-chart-line"></i> Dashboard</a>
                <a href="students.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'students.php' ? 'active' : ''; ?>"><i class="fas fa-users"></i> Students</a>
                <a href="templates.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'templates.php' ? 'active' : ''; ?>"><i class="fas fa-paint-brush"></i> Templates</a>
                <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <header class="top-header">
                <div class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="user-info">
                    <span>Admin: <?php echo htmlspecialchars($_SESSION['name']); ?></span>
                    <div class="avatar-placeholder" style="background: #f59e0b;"><i class="fas fa-user-shield"></i></div>
                </div>
            </header>
            <div class="content-wrapper">
