<?php
$page_title = 'My Achievements';
require_once '../includes/header.php';

$success = '';
$error = '';
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        $title = trim($_POST['title']);
        $organization = trim($_POST['organization']);
        $date = trim($_POST['date']);
        $description = trim($_POST['description']);
        
        if (empty($title) || empty($organization) || empty($date) || empty($description)) {
            $error = "All fields are required.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO achievements (user_id, title, organization, date, description) VALUES (?, ?, ?, ?, ?)");
            if ($stmt->execute([$user_id, $title, $organization, $date, $description])) {
                $success = "Achievement added successfully.";
            }
        }
    } elseif ($_POST['action'] == 'delete') {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM achievements WHERE id = ? AND user_id = ?");
        if ($stmt->execute([$id, $user_id])) {
            $success = "Achievement deleted successfully.";
        }
    }
}

$stmt = $pdo->prepare("SELECT * FROM achievements WHERE user_id = ? ORDER BY date DESC");
$stmt->execute([$user_id]);
$achievements = $stmt->fetchAll();
?>

<h1 class="page-title">Manage Achievements</h1>

<?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>
<?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>

<div style="display: flex; gap: 30px; align-items: flex-start; flex-wrap: wrap;">
    <div class="form-container" style="flex: 1; min-width: 300px; margin: 0;">
        <h3 style="margin-top: 0;">Add Achievement</h3>
        <form method="POST">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label>Achievement Title *</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Organization / Event *</label>
                <input type="text" name="organization" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Date *</label>
                <input type="date" name="date" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Description *</label>
                <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn-primary">Add Achievement</button>
        </form>
    </div>

    <div style="flex: 2; min-width: 300px;">
        <?php if(empty($achievements)): ?>
            <div class="card"><p>No achievements added yet.</p></div>
        <?php else: ?>
            <div class="item-list">
                <?php foreach($achievements as $a): ?>
                    <div class="list-item" style="align-items: flex-start;">
                        <div class="item-details" style="flex: 1;">
                            <h4 style="font-size: 18px; color: var(--primary);"><i class="fas fa-trophy"></i> <?php echo htmlspecialchars($a['title']); ?></h4>
                            <p style="font-weight: 600; color: #333; margin: 5px 0;"><?php echo htmlspecialchars($a['organization']); ?></p>
                            <p style="color: #666; margin-bottom: 10px;">
                                <i class="far fa-calendar-alt"></i> <?php echo htmlspecialchars($a['date']); ?>
                            </p>
                            <p style="margin-top: 10px; color: #555;"><?php echo htmlspecialchars($a['description']); ?></p>
                        </div>
                        <div class="item-actions">
                            <form method="POST" style="display:inline;" class="delete-form" data-confirm-msg="Delete this record?">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $a['id']; ?>">
                                <button type="submit" class="btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
