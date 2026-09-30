<?php
$page_title = 'Manage Templates';
require_once 'header.php';

$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $id = $_POST['id'];
    
    if ($_POST['action'] == 'activate') {
        $pdo->prepare("UPDATE templates SET status = 'active' WHERE id = ?")->execute([$id]);
        $success = "Template activated.";
    } elseif ($_POST['action'] == 'deactivate') {
        $pdo->prepare("UPDATE templates SET status = 'inactive' WHERE id = ?")->execute([$id]);
        $success = "Template deactivated.";
    }
}

$stmt = $pdo->query("SELECT * FROM templates ORDER BY created_at DESC");
$templates = $stmt->fetchAll();
?>

<h1 class="page-title">Manage Templates</h1>

<?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
    <?php foreach($templates as $t): ?>
        <div class="card" style="padding: 0; overflow: hidden; opacity: <?php echo $t['status'] == 'inactive' ? '0.6' : '1'; ?>;">
            <div style="height: 150px; background: #eaeaea; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-file-code" style="font-size: 40px; color: #999;"></i>
            </div>
            <div style="padding: 20px;">
                <h3 style="margin: 0 0 5px 0;"><?php echo htmlspecialchars($t['name']); ?></h3>
                <p style="color: #666; font-size: 13px; margin: 0 0 15px 0;"><strong>File:</strong> <?php echo htmlspecialchars($t['template_file']); ?></p>
                <p style="font-size: 14px; margin-bottom: 20px;"><?php echo htmlspecialchars($t['description']); ?></p>
                
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $t['id']; ?>">
                    <?php if($t['status'] == 'active'): ?>
                        <input type="hidden" name="action" value="deactivate">
                        <button type="submit" class="btn-danger" style="width: 100%;">Deactivate Template</button>
                    <?php else: ?>
                        <input type="hidden" name="action" value="activate">
                        <button type="submit" class="btn-primary" style="background: #28a745; width: 100%;">Activate Template</button>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once '../includes/footer.php'; ?>
