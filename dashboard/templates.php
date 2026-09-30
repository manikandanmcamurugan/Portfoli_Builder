<?php
$page_title = 'Templates';
require_once '../includes/header.php';

$success = '';
$error = '';
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['template_id'])) {
    $template_id = (int)$_POST['template_id'];
    
    // Check if portfolio setting exists
    $stmt = $pdo->prepare("SELECT id FROM portfolio_settings WHERE user_id = ?");
    $stmt->execute([$user_id]);
    
    if ($stmt->fetch()) {
        $stmt = $pdo->prepare("UPDATE portfolio_settings SET template_id = ? WHERE user_id = ?");
        $stmt->execute([$template_id, $user_id]);
    } else {
        // Generate a random slug just in case
        $slug = 'portfolio-' . $user_id . '-' . rand(1000, 9999);
        $stmt = $pdo->prepare("INSERT INTO portfolio_settings (user_id, template_id, portfolio_slug) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $template_id, $slug]);
    }
    $success = "Template selected successfully!";
}

// Ensure at least 2 templates exist in DB for demo purposes
$stmt = $pdo->query("SELECT COUNT(*) FROM templates");
if ($stmt->fetchColumn() == 0) {
    $pdo->exec("INSERT INTO templates (name, slug, description, template_file) VALUES 
        ('Modern', 'modern', 'A sleek, modern design with bold typography.', 'template1.php'),
        ('Professional', 'professional', 'A clean, corporate layout for professionals.', 'template2.php')
    ");
}

$stmt = $pdo->query("SELECT * FROM templates WHERE status = 'active'");
$templates = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT template_id FROM portfolio_settings WHERE user_id = ?");
$stmt->execute([$user_id]);
$current_template = $stmt->fetchColumn();
?>

<h1 class="page-title">Choose Your Template</h1>

<?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
    <?php foreach($templates as $t): ?>
        <div class="card" style="padding: 0; overflow: hidden; border: <?php echo ($current_template == $t['id']) ? '3px solid var(--primary)' : '1px solid #eee'; ?>;">
            
            <?php if($t["preview_image"]): ?>
                <img src="../assets/images/uploads/templates/<?php echo htmlspecialchars($t["preview_image"]); ?>?v=<?php echo time(); ?>" style="width:100%; height:auto; aspect-ratio:4/3; object-fit:contain; background:#f4f7f6;">
            <?php else: ?>
                <div style="height: 200px; background: #eaeaea; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-paint-roller" style="font-size: 50px; color: #ccc;"></i>
                </div>
            <?php endif; ?>
            <div style="padding: 20px; text-align: center;">
                <h3 style="margin: 0 0 10px 0;"><?php echo htmlspecialchars($t['name']); ?></h3>
                <p style="color: #666; font-size: 14px; margin-bottom: 20px;"><?php echo htmlspecialchars($t['description']); ?></p>
                
                <?php if($current_template == $t['id']): ?>
                    <button class="btn-primary" style="background: #28a745; width: 100%;" disabled><i class="fas fa-check"></i> SELECTED</button>
                <?php else: ?>
                    <form method="POST">
                        <input type="hidden" name="template_id" value="<?php echo $t['id']; ?>">
                        <button type="submit" class="btn-primary" style="width: 100%;">Use This Template</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once '../includes/footer.php'; ?>




