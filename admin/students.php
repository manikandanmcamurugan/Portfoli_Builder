<?php
$page_title = 'Manage Students';
require_once 'header.php';

$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $id = $_POST['id'];
    
    if ($_POST['action'] == 'activate') {
        $pdo->prepare("UPDATE users SET status = 'active' WHERE id = ?")->execute([$id]);
        $success = "Student activated.";
    } elseif ($_POST['action'] == 'deactivate') {
        $pdo->prepare("UPDATE users SET status = 'inactive' WHERE id = ?")->execute([$id]);
        $success = "Student deactivated.";
    }
}

$stmt = $pdo->query("
    SELECT u.*, p.full_name, ps.portfolio_slug, ps.is_published 
    FROM users u 
    LEFT JOIN profiles p ON u.id = p.user_id 
    LEFT JOIN portfolio_settings ps ON u.id = ps.user_id 
    WHERE u.role = 'student' 
    ORDER BY u.created_at DESC
");
$students = $stmt->fetchAll();
?>

<h1 class="page-title">Manage Students</h1>

<?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>

<div class="card" style="overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="border-bottom: 2px solid #eee;">
                <th style="padding: 15px;">Name</th>
                <th style="padding: 15px;">Email</th>
                <th style="padding: 15px;">Status</th>
                <th style="padding: 15px;">Portfolio</th>
                <th style="padding: 15px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($students as $s): ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 15px; font-weight: 500;"><?php echo htmlspecialchars($s['full_name'] ?: $s['name']); ?></td>
                    <td style="padding: 15px;"><?php echo htmlspecialchars($s['email']); ?></td>
                    <td style="padding: 15px;">
                        <?php if($s['status'] == 'active'): ?>
                            <span style="background: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">ACTIVE</span>
                        <?php else: ?>
                            <span style="background: #f8d7da; color: #721c24; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">INACTIVE</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 15px;">
                        <?php if($s['is_published'] && $s['portfolio_slug']): ?>
                            <a href="../portfolio/view.php?user=<?php echo $s['portfolio_slug']; ?>" target="_blank" style="color: #0066ff;">View Live</a>
                        <?php else: ?>
                            <span style="color: #999;">Not Published</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 15px;">
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $s['id']; ?>">
                            <?php if($s['status'] == 'active'): ?>
                                <input type="hidden" name="action" value="deactivate">
                                <button type="submit" class="btn-danger" style="padding: 5px 10px; font-size: 12px;" onclick="return confirm('Deactivate this student?');">Deactivate</button>
                            <?php else: ?>
                                <input type="hidden" name="action" value="activate">
                                <button type="submit" class="btn-primary" style="background: #28a745; padding: 5px 10px; font-size: 12px;">Activate</button>
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once '../includes/footer.php'; ?>
