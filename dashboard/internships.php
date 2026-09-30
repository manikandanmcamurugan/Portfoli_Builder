<?php
$page_title = 'My Internships';
require_once '../includes/header.php';

$success = '';
$error = '';
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        $company = trim($_POST['company']);
        $role = trim($_POST['role']);
        $start_date = trim($_POST['start_date']);
        $end_date = trim($_POST['end_date']);
        $description = trim($_POST['description']);
        
        $certificate_file = null;
        if (isset($_FILES['certificate']) && $_FILES['certificate']['error'] == 0) {
            $ext = strtolower(pathinfo($_FILES['certificate']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['pdf', 'jpg', 'jpeg', 'png'])) {
                $certificate_file = uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['certificate']['tmp_name'], '../assets/images/uploads/certificates/' . $certificate_file);
            }
        }
        
        if (empty($company) || empty($role) || empty($start_date)) {
            $error = "Company, Role, and Start Date are required.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO internships (user_id, company, role, start_date, end_date, description, certificate_file) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$user_id, $company, $role, $start_date, empty($end_date) ? null : $end_date, $description, $certificate_file])) {
                $success = "Internship added successfully.";
            }
        }
    } elseif ($_POST['action'] == 'delete') {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM internships WHERE id = ? AND user_id = ?");
        if ($stmt->execute([$id, $user_id])) {
            $success = "Internship deleted successfully.";
        }
    }
}

$stmt = $pdo->prepare("SELECT * FROM internships WHERE user_id = ? ORDER BY start_date DESC");
$stmt->execute([$user_id]);
$internships = $stmt->fetchAll();
?>

<h1 class="page-title">Manage Internships</h1>

<?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>
<?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>

<div style="display: flex; gap: 30px; align-items: flex-start; flex-wrap: wrap;">
    <div class="form-container" style="flex: 1; min-width: 300px; margin: 0;">
        <h3 style="margin-top: 0;">Add Internship</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label>Company *</label>
                <input type="text" name="company" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Role *</label>
                <input type="text" name="role" class="form-control" required>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Start Date *</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" name="end_date" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>Upload Certificate (Optional)</label>
                <input type="file" name="certificate" class="form-control" accept=".pdf,image/*">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn-primary">Add Internship</button>
        </form>
    </div>

    <div style="flex: 2; min-width: 300px;">
        <?php if(empty($internships)): ?>
            <div class="card"><p>No internships added yet.</p></div>
        <?php else: ?>
            <div class="item-list">
                <?php foreach($internships as $i): ?>
                    <div class="list-item" style="align-items: flex-start;">
                        <div class="item-details" style="flex: 1;">
                            <h4 style="font-size: 18px; color: var(--primary);"><i class="fas fa-briefcase"></i> <?php echo htmlspecialchars($i['role']); ?></h4>
                            <p style="font-weight: 600; color: #333; margin: 5px 0;"><?php echo htmlspecialchars($i['company']); ?></p>
                            <p style="color: #666; margin-bottom: 10px;">
                                <i class="far fa-calendar-alt"></i> <?php echo htmlspecialchars($i['start_date']); ?> - <?php echo $i['end_date'] ? htmlspecialchars($i['end_date']) : 'Present'; ?>
                            </p>
                            <?php if($i['description']): ?><p style="margin-top: 10px; color: #555;"><?php echo htmlspecialchars($i['description']); ?></p><?php endif; ?>
                            <?php if($i['certificate_file']): ?>
                                <a href="../assets/images/uploads/certificates/<?php echo htmlspecialchars($i['certificate_file']); ?>" target="_blank" style="font-size: 13px; color: var(--primary);"><i class="fas fa-certificate"></i> View Certificate</a>
                            <?php endif; ?>
                        </div>
                        <div class="item-actions">
                            <form method="POST" style="display:inline;" class="delete-form" data-confirm-msg="Delete this record?">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $i['id']; ?>">
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
