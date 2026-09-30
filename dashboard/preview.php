<?php
$page_title = 'Preview Portfolio';
require_once '../includes/header.php';

$user_id = $_SESSION['user_id'];

// Get settings
$stmt = $pdo->prepare("SELECT * FROM portfolio_settings WHERE user_id = ?");
$stmt->execute([$user_id]);
$settings = $stmt->fetch();

if (!$settings || !$settings['template_id']) {
    echo "<div class='alert alert-danger'>You need to select a template first! <a href='templates.php'>Go to Templates</a></div>";
    require_once '../includes/footer.php';
    exit;
}

$preview_url = "../portfolio/view.php?user=" . $settings['portfolio_slug'];
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1 class="page-title" style="margin: 0;">Live Preview</h1>
    <div style="display: flex; gap: 10px;">`n        <a href="templates.php" class="btn-primary" style="background: #6c757d; text-decoration: none;"><i class="fas fa-paint-brush"></i> Change Template</a>
        <a href="settings.php" class="btn-primary" style="background: #28a745; text-decoration: none;"><i class="fas fa-globe"></i> Publish</a>
    </div>
</div>

<div class="card" style="padding: 0; overflow: hidden; height: 75vh; border: 2px solid #ccc;">
    <iframe src="<?php echo $preview_url; ?>" style="width: 100%; height: 100%; border: none;"></iframe>
</div>

<?php require_once '../includes/footer.php'; ?>

