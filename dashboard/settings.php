<?php
$page_title = 'Settings';
require_once '../includes/header.php';

$success = '';
$error = '';
$user_id = $_SESSION['user_id'];

// Get current settings
$stmt = $pdo->prepare("SELECT * FROM portfolio_settings WHERE user_id = ?");
$stmt->execute([$user_id]);
$settings = $stmt->fetch();

if (!$settings) {
    $slug = 'user-' . $user_id;
    $stmt = $pdo->prepare("INSERT INTO portfolio_settings (user_id, portfolio_slug) VALUES (?, ?)");
    $stmt->execute([$user_id, $slug]);
    $settings = ['portfolio_slug' => $slug, 'is_published' => 0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $slug = trim($_POST['slug']);
    $is_published = isset($_POST['is_published']) ? 1 : 0;
    
    // Check slug uniqueness
    $stmt = $pdo->prepare("SELECT id FROM portfolio_settings WHERE portfolio_slug = ? AND user_id != ?");
    $stmt->execute([$slug, $user_id]);
    if ($stmt->fetch()) {
        $error = "This URL slug is already taken. Please choose another.";
    } else {
        $stmt = $pdo->prepare("UPDATE portfolio_settings SET portfolio_slug = ?, is_published = ? WHERE user_id = ?");
        if ($stmt->execute([$slug, $is_published, $user_id])) {
            $success = "Settings updated successfully.";
            $settings['portfolio_slug'] = $slug;
            $settings['is_published'] = $is_published;
        }
    }
}

$base_url = "http://localhost/Portfolio_Builder/portfolio/view.php?user=";
?>

<h1 class="page-title">Portfolio Settings</h1>

<?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>
<?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>

<div class="form-container">
    <form method="POST">
        <div class="form-group">
            <label>Public URL Slug</label>
            <div style="display: flex; align-items: center; background: #eee; padding: 10px; border-radius: 6px;">
                <span style="color: #666; margin-right: 5px;"><?php echo $base_url; ?></span>
                <input type="text" name="slug" class="form-control" style="border: none; padding: 5px; flex: 1;" value="<?php echo htmlspecialchars($settings['portfolio_slug']); ?>" required>
            </div>
        </div>

        <div class="form-group" style="margin-top: 30px;">
            <label style="display: flex; align-items: center; cursor: pointer;">
                <input type="checkbox" name="is_published" value="1" <?php echo $settings['is_published'] ? 'checked' : ''; ?> style="width: 20px; height: 20px; margin-right: 10px;">
                <span style="font-size: 16px; font-weight: 600;">Publish Portfolio</span>
            </label>
            <p style="color: #666; font-size: 14px; margin-left: 30px;">If unchecked, your portfolio will not be accessible to the public.</p>
        </div>

        <button type="submit" class="btn-primary" style="margin-top: 20px;">Save Settings</button>
    </form>
    
    <?php if($settings['is_published']): ?>
        <hr style="margin: 40px 0; border: 0; border-top: 1px solid #ddd;">
        <h3>Your Portfolio is Live!</h3>
        <p>You can share this link with anyone:</p>
        <a href="<?php echo $base_url . htmlspecialchars($settings['portfolio_slug']); ?>" target="_blank" style="font-size: 18px; font-weight: 600; color: var(--primary); text-decoration: none;">
            <?php echo $base_url . htmlspecialchars($settings['portfolio_slug']); ?>
        </a>
    <?php endif; ?>
</div>

<?php require_once '../includes/footer.php'; ?>

