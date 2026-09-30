<?php
$page_title = 'My Skills';
require_once '../includes/header.php';

$success = '';
$error = '';
$user_id = $_SESSION['user_id'];

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'add' || $_POST['action'] == 'edit') {
        $skill_name = trim($_POST['skill_name']);
        $skill_level = $_POST['skill_level'];
        
        if (empty($skill_name)) {
            $error = "Skill name is required.";
        } else {
            if ($_POST['action'] == 'add') {
                $stmt = $pdo->prepare("INSERT INTO skills (user_id, skill_name, skill_level) VALUES (?, ?, ?)");
                if ($stmt->execute([$user_id, $skill_name, $skill_level])) {
                    $success = "Skill added successfully.";
                }
            } else {
                $id = $_POST['id'];
                $stmt = $pdo->prepare("UPDATE skills SET skill_name = ?, skill_level = ? WHERE id = ? AND user_id = ?");
                if ($stmt->execute([$skill_name, $skill_level, $id, $user_id])) {
                    $success = "Skill updated successfully.";
                }
            }
        }
    } elseif ($_POST['action'] == 'delete') {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM skills WHERE id = ? AND user_id = ?");
        if ($stmt->execute([$id, $user_id])) {
            $success = "Skill deleted successfully.";
        }
    }
}

// Fetch skills
$stmt = $pdo->prepare("SELECT * FROM skills WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$skills = $stmt->fetchAll();
?>

<h1 class="page-title">Manage Skills</h1>

<?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>
<?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>

<div style="display: flex; gap: 30px; align-items: flex-start; flex-wrap: wrap;">
    <!-- Add Form -->
    <div class="form-container" style="flex: 1; min-width: 300px; margin: 0;">
        <h3 style="margin-top: 0;">Add New Skill</h3>
        <form method="POST">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label>Skill Name</label>
                <input type="text" name="skill_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Proficiency Level</label>
                <select name="skill_level" class="form-control" required>
                    <option value="Beginner">Beginner</option>
                    <option value="Intermediate">Intermediate</option>
                    <option value="Advanced">Advanced</option>
                    <option value="Expert">Expert</option>
                </select>
            </div>
            <button type="submit" class="btn-primary">Add Skill</button>
        </form>
    </div>

    <!-- Skills List -->
    <div style="flex: 2; min-width: 300px;">
        <?php if(empty($skills)): ?>
            <div class="card"><p>No skills added yet.</p></div>
        <?php else: ?>
            <div class="item-list">
                <?php foreach($skills as $s): ?>
                    <div class="list-item">
                        <div class="item-details">
                            <h4><?php echo htmlspecialchars($s['skill_name']); ?></h4>
                            <p><?php echo htmlspecialchars($s['skill_level']); ?></p>
                        </div>
                        <div class="item-actions">
                            <form method="POST" style="display:inline;" class="delete-form" data-confirm-msg="Delete this skill?">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $s['id']; ?>">
                                <button type="submit" class="btn-danger"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
