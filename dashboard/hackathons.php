<?php
$page_title = 'My Hackathons';
require_once '../includes/header.php';

$success = '';
$error = '';
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        $name = trim($_POST['name']);
        $organizer = trim($_POST['organizer']);
        $date = trim($_POST['date']);
        $position = trim($_POST['position']);
        $description = trim($_POST['description']);
        
        $certificate_file = null;
        if (isset($_FILES['certificate']) && $_FILES['certificate']['error'] == 0) {
            $ext = strtolower(pathinfo($_FILES['certificate']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['pdf', 'jpg', 'jpeg', 'png'])) {
                $certificate_file = uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['certificate']['tmp_name'], '../assets/images/uploads/certificates/' . $certificate_file);
            }
        }
        
        if (empty($name) || empty($organizer) || empty($date)) {
            $error = "Hackathon Name, Organizer, and Date are required.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO hackathons (user_id, name, organizer, date, position, description, certificate_file) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$user_id, $name, $organizer, $date, $position, $description, $certificate_file])) {
                $success = "Hackathon added successfully.";
            }
        }
    } elseif ($_POST['action'] == 'delete') {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM hackathons WHERE id = ? AND user_id = ?");
        if ($stmt->execute([$id, $user_id])) {
            $success = "Hackathon deleted successfully.";
        }
    }
}

$stmt = $pdo->prepare("SELECT * FROM hackathons WHERE user_id = ? ORDER BY date DESC");
$stmt->execute([$user_id]);
$hackathons = $stmt->fetchAll();
?>

<h1 class="page-title">Manage Hackathons</h1>

<?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>
<?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>

<div style="display: flex; gap: 30px; align-items: flex-start; flex-wrap: wrap;">
    <div class="form-container" style="flex: 1; min-width: 300px; margin: 0;">
        <h3 style="margin-top: 0;">Add Hackathon</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label>Hackathon Name *</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Organizer *</label>
                <input type="text" name="organizer" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Date *</label>
                <input type="date" name="date" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Position / Rank</label>
                <input type="text" name="position" class="form-control" placeholder="e.g. 1st Place, Finalist">
            </div>
            <div class="form-group">
                <label>Upload Certificate (Optional)</label>
                <input type="file" name="certificate" class="form-control" accept=".pdf,image/*">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn-primary">Add Hackathon</button>
        </form>
    </div>

    <div style="flex: 2; min-width: 300px;">
        <?php if(empty($hackathons)): ?>
            <div class="card"><p>No hackathons added yet.</p></div>
        <?php else: ?>
            <div class="item-list">
                <?php foreach($hackathons as $h): ?>
                    <div class="list-item" style="align-items: flex-start;">
                        <div class="item-details" style="flex: 1;">
                            <h4 style="font-size: 18px; color: var(--primary);"><i class="fas fa-code"></i> <?php echo htmlspecialchars($h['name']); ?></h4>
                            <p style="font-weight: 600; color: #333; margin: 5px 0;"><?php echo htmlspecialchars($h['organizer']); ?></p>
                            <p style="color: #666; margin-bottom: 10px;">
                                <i class="far fa-calendar-alt"></i> <?php echo htmlspecialchars($h['date']); ?>
                            </p>
                            <?php if($h['position']): ?><span style="background: #eee; padding: 4px 10px; border-radius: 4px; font-size: 13px; font-weight: 600;">Position: <?php echo htmlspecialchars($h['position']); ?></span><?php endif; ?>
                            <?php if($h['description']): ?><p style="margin-top: 10px; color: #555;"><?php echo htmlspecialchars($h['description']); ?></p><?php endif; ?>
                            <?php if($h['certificate_file']): ?>
                                <p style="margin-top: 10px;"><a href="../assets/images/uploads/certificates/<?php echo htmlspecialchars($h['certificate_file']); ?>" target="_blank" style="font-size: 13px; color: var(--primary);"><i class="fas fa-certificate"></i> View Certificate</a></p>
                            <?php endif; ?>
                        </div>
                        <div class="item-actions">
                            <form method="POST" style="display:inline;" class="delete-form" data-confirm-msg="Delete this record?">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $h['id']; ?>">
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
