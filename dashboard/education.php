<?php
$page_title = 'My Education';
require_once '../includes/header.php';

$success = '';
$error = '';
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        $degree = trim($_POST['degree']);
        $college = trim($_POST['college']);
        $department = trim($_POST['department']);
        $start_year = trim($_POST['start_year']);
        $end_year = trim($_POST['end_year']);
        $percentage = trim($_POST['percentage']);
        $cgpa = trim($_POST['cgpa']);
        $description = trim($_POST['description']);
        
        if (empty($degree) || empty($college) || empty($start_year)) {
            $error = "Degree, College, and Start Year are required.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO education (user_id, degree, college, department, start_year, end_year, percentage, cgpa, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$user_id, $degree, $college, $department, $start_year, $end_year, $percentage ?: null, $cgpa ?: null, $description])) {
                $success = "Education added successfully.";
            }
        }
    } elseif ($_POST['action'] == 'delete') {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM education WHERE id = ? AND user_id = ?");
        if ($stmt->execute([$id, $user_id])) {
            $success = "Education deleted successfully.";
        }
    }
}

$stmt = $pdo->prepare("SELECT * FROM education WHERE user_id = ? ORDER BY start_year DESC");
$stmt->execute([$user_id]);
$education = $stmt->fetchAll();
?>

<h1 class="page-title">Manage Education</h1>

<?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>
<?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>

<div style="display: flex; gap: 30px; align-items: flex-start; flex-wrap: wrap;">
    <!-- Add Form -->
    <div class="form-container" style="flex: 1; min-width: 300px; margin: 0;">
        <h3 style="margin-top: 0;">Add Education</h3>
        <form method="POST">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label>Degree / Qualification *</label>
                <input type="text" name="degree" class="form-control" required>
            </div>
            <div class="form-group">
                <label>College / School *</label>
                <input type="text" name="college" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Department</label>
                <input type="text" name="department" class="form-control">
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Start Year *</label>
                    <input type="number" name="start_year" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>End Year</label>
                    <input type="number" name="end_year" class="form-control" placeholder="Leave blank if current">
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>CGPA</label>
                    <input type="number" step="0.01" name="cgpa" class="form-control">
                </div>
                <div class="form-group">
                    <label>Percentage (%)</label>
                    <input type="number" step="0.01" name="percentage" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn-primary">Add Education</button>
        </form>
    </div>

    <!-- List -->
    <div style="flex: 2; min-width: 300px;">
        <?php if(empty($education)): ?>
            <div class="card"><p>No education added yet.</p></div>
        <?php else: ?>
            <div class="item-list">
                <?php foreach($education as $e): ?>
                    <div class="list-item" style="align-items: flex-start;">
                        <div class="item-details" style="flex: 1;">
                            <h4 style="font-size: 18px; color: var(--primary);"><i class="fas fa-graduation-cap"></i> <?php echo htmlspecialchars($e['degree']); ?></h4>
                            <p style="font-weight: 600; color: #333; margin: 5px 0;"><?php echo htmlspecialchars($e['college']); ?></p>
                            <?php if($e['department']): ?><p style="margin-bottom: 5px;"><strong>Dept:</strong> <?php echo htmlspecialchars($e['department']); ?></p><?php endif; ?>
                            <p style="color: #666; margin-bottom: 10px;">
                                <i class="far fa-calendar-alt"></i> <?php echo htmlspecialchars($e['start_year']); ?> - <?php echo $e['end_year'] ? htmlspecialchars($e['end_year']) : 'Present'; ?>
                            </p>
                            <?php if($e['cgpa']): ?><span style="background: #eee; padding: 4px 10px; border-radius: 4px; font-size: 13px; font-weight: 600;">CGPA: <?php echo htmlspecialchars($e['cgpa']); ?></span><?php endif; ?>
                            <?php if($e['percentage']): ?><span style="background: #eee; padding: 4px 10px; border-radius: 4px; font-size: 13px; font-weight: 600; margin-left: 10px;">Percent: <?php echo htmlspecialchars($e['percentage']); ?>%</span><?php endif; ?>
                            <?php if($e['description']): ?><p style="margin-top: 10px; color: #555;"><?php echo htmlspecialchars($e['description']); ?></p><?php endif; ?>
                        </div>
                        <div class="item-actions">
                            <form method="POST" style="display:inline;" class="delete-form" data-confirm-msg="Delete this record?">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $e['id']; ?>">
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
