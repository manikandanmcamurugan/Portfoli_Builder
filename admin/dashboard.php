<?php
$page_title = 'Dashboard';
require_once 'header.php';

// Stats
$stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'student'");
$total_students = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'student' AND status = 'active'");
$active_students = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM portfolio_settings WHERE is_published = 1");
$published_portfolios = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM templates WHERE status = 'active'");
$active_templates = $stmt->fetchColumn();
?>

<h1 class="page-title">Admin Dashboard</h1>

<div class="dashboard-cards">
    <div class="card">
        <div class="card-icon"><i class="fas fa-users"></i></div>
        <div class="card-title">Total Students</div>
        <h3 class="card-value"><?php echo $total_students; ?></h3>
    </div>
    
    <div class="card">
        <div class="card-icon"><i class="fas fa-user-check"></i></div>
        <div class="card-title">Active Students</div>
        <h3 class="card-value"><?php echo $active_students; ?></h3>
    </div>
    
    <div class="card">
        <div class="card-icon"><i class="fas fa-globe"></i></div>
        <div class="card-title">Published Portfolios</div>
        <h3 class="card-value"><?php echo $published_portfolios; ?></h3>
    </div>
    
    <div class="card">
        <div class="card-icon"><i class="fas fa-paint-brush"></i></div>
        <div class="card-title">Active Templates</div>
        <h3 class="card-value"><?php echo $active_templates; ?></h3>
    </div>
</div>

<div class="card">
    <h3 style="margin-top: 0;">Quick Actions</h3>
    <a href="students.php" class="btn-primary" style="display: inline-block; text-decoration: none; margin-right: 15px;">Manage Students</a>
    <a href="templates.php" class="btn-primary" style="display: inline-block; text-decoration: none; background: #6c757d;">Manage Templates</a>
</div>

<?php require_once '../includes/footer.php'; ?>
