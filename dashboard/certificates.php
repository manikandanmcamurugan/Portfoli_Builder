<?php
$page_title = 'My Certificates';
require_once '../includes/header.php';

$success = '';
$error = '';
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        $title = trim($_POST['title']);
        $issuing_organization = trim($_POST['issuing_organization']);
        $issue_date = trim($_POST['issue_date']);
        $description = trim($_POST['description']);
        
        $certificate_file = null;
        if (isset($_FILES['certificate']) && $_FILES['certificate']['error'] == 0) {
            $ext = strtolower(pathinfo($_FILES['certificate']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['pdf', 'jpg', 'jpeg', 'png'])) {
                $certificate_file = uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['certificate']['tmp_name'], '../assets/images/uploads/certificates/' . $certificate_file);
            } else {
                $error = "Invalid file type. Allowed: PDF, JPG, PNG.";
            }
        }
        
        if (empty($title) || empty($issuing_organization) || empty($issue_date)) {
            $error = "Title, Organization, and Date are required.";
        } else if (empty($error)) {
            $stmt = $pdo->prepare("INSERT INTO certificates (user_id, title, issuing_organization, issue_date, certificate_file, description) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$user_id, $title, $issuing_organization, $issue_date, $certificate_file, $description])) {
                $success = "Certificate added successfully.";
            }
        }
    } elseif ($_POST['action'] == 'delete') {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("SELECT certificate_file FROM certificates WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $user_id]);
        $cert = $stmt->fetch();
        if ($cert && $cert['certificate_file']) {
            @unlink('../assets/images/uploads/certificates/' . $cert['certificate_file']);
        }
        
        $stmt = $pdo->prepare("DELETE FROM certificates WHERE id = ? AND user_id = ?");
        if ($stmt->execute([$id, $user_id])) {
            $success = "Certificate deleted successfully.";
        }
    }
}

$stmt = $pdo->prepare("SELECT * FROM certificates WHERE user_id = ? ORDER BY issue_date DESC");
$stmt->execute([$user_id]);
$certificates = $stmt->fetchAll();
?>

<h1 class="page-title">Manage Certificates</h1>

<?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>
<?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>

<div style="display: flex; gap: 30px; align-items: flex-start; flex-wrap: wrap;">
    <!-- Add Form -->
    <div class="form-container" style="flex: 1; min-width: 300px; margin: 0;">
        <h3 style="margin-top: 0;">Add Certificate</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label>Certificate Title *</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Issuing Organization *</label>
                <input type="text" name="issuing_organization" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Issue Date *</label>
                <input type="date" name="issue_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Upload Certificate (PDF, JPG, PNG)</label>
                <input type="file" name="certificate" class="form-control" accept=".pdf,image/*">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn-primary">Add Certificate</button>
        </form>
    </div>

    <!-- List -->
    <div style="flex: 2; min-width: 300px;">
        <?php if(empty($certificates)): ?>
            <div class="card"><p>No certificates added yet.</p></div>
        <?php else: ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
                <?php foreach($certificates as $c): ?>
                    <div class="card" style="padding: 20px; border-top: 4px solid var(--primary);">
                        <div style="display: flex; align-items: center; margin-bottom: 15px;">
                            <i class="fas fa-award fa-2x" style="color: gold; margin-right: 15px;"></i>
                            <h4 style="margin: 0; line-height: 1.3;"><?php echo htmlspecialchars($c['title']); ?></h4>
                        </div>
                        <p style="font-weight: 600; color: #555; margin: 0 0 5px 0;"><?php echo htmlspecialchars($c['issuing_organization']); ?></p>
                        <p style="color: #888; font-size: 13px; margin: 0 0 15px 0;"><i class="far fa-calendar-alt"></i> Issued: <?php echo date('M Y', strtotime($c['issue_date'])); ?></p>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #eee; padding-top: 15px;">
                            <?php if($c['certificate_file']): ?>
                                <a href="../assets/images/uploads/certificates/<?php echo htmlspecialchars($c['certificate_file']); ?>" target="_blank" class="btn-primary" style="padding: 6px 12px; font-size: 13px; text-decoration: none;"><i class="fas fa-eye"></i> View</a>
                            <?php else: ?>
                                <span style="font-size: 13px; color: #999;">No file attached</span>
                            <?php endif; ?>
                            
                            <form method="POST" class="delete-form" data-confirm-msg="Delete this certificate?">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $c['id']; ?>">
                                <button type="submit" class="btn-danger" style="padding: 6px 12px; font-size: 13px;"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
