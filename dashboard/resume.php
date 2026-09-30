<?php
$page_title = 'My Resume';
require_once '../includes/header.php';

$success = '';
$error = '';
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'upload') {
        if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
            $ext = strtolower(pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION));
            if ($ext === 'pdf') {
                $filename = 'resume_' . $user_id . '_' . uniqid() . '.pdf';
                if (move_uploaded_file($_FILES['resume']['tmp_name'], '../assets/images/uploads/resume/' . $filename)) {
                    // Delete old resume if exists
                    $stmt = $pdo->prepare("SELECT file_path FROM resumes WHERE user_id = ?");
                    $stmt->execute([$user_id]);
                    $old = $stmt->fetch();
                    if ($old && file_exists('../assets/images/uploads/resume/' . $old['file_path'])) {
                        @unlink('../assets/images/uploads/resume/' . $old['file_path']);
                        $pdo->prepare("DELETE FROM resumes WHERE user_id = ?")->execute([$user_id]);
                    }
                    
                    $stmt = $pdo->prepare("INSERT INTO resumes (user_id, file_name, file_path) VALUES (?, ?, ?)");
                    if ($stmt->execute([$user_id, $_FILES['resume']['name'], $filename])) {
                        $success = "Resume uploaded successfully.";
                    }
                } else {
                    $error = "Failed to move uploaded file.";
                }
            } else {
                $error = "Only PDF files are allowed.";
            }
        } else {
            $error = "Please select a valid PDF file.";
        }
    } elseif ($_POST['action'] == 'delete') {
        $stmt = $pdo->prepare("SELECT file_path FROM resumes WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $old = $stmt->fetch();
        if ($old && file_exists('../assets/images/uploads/resume/' . $old['file_path'])) {
            @unlink('../assets/images/uploads/resume/' . $old['file_path']);
        }
        $pdo->prepare("DELETE FROM resumes WHERE user_id = ?")->execute([$user_id]);
        $success = "Resume deleted successfully.";
    }
}

$stmt = $pdo->prepare("SELECT * FROM resumes WHERE user_id = ? ORDER BY uploaded_at DESC LIMIT 1");
$stmt->execute([$user_id]);
$resume = $stmt->fetch();
?>

<h1 class="page-title">Manage Resume</h1>
<div class="card" style="max-width: 600px; margin: 30px auto; text-align: center; padding: 40px; border-top: 5px solid var(--accent);">
    <i class="fas fa-magic" style="font-size: 60px; color: var(--accent); margin-bottom: 20px;"></i>
    <h3 style="margin: 0 0 10px 0;">Auto-Build Resume</h3>
    <p style="color: #666; margin-bottom: 30px;">Don't have a PDF? We can automatically generate a professional resume using your Profile, Education, Skills, and Projects!</p>
    <a href="generate_resume.php" target="_blank" class="btn-primary" style="display: inline-block; text-decoration: none; padding: 15px 30px; font-size: 18px;"><i class="fas fa-file-invoice"></i> Generate & Download Resume</a>
</div>

<?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>
<?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>

<div class="card" style="max-width: 600px; margin: 0 auto; text-align: center; padding: 40px;">
    <?php if($resume): ?>
        <i class="fas fa-file-pdf" style="font-size: 80px; color: #dc3545; margin-bottom: 20px;"></i>
        <h3 style="margin: 0 0 10px 0;"><?php echo htmlspecialchars($resume['file_name']); ?></h3>
        <p style="color: #666; margin-bottom: 30px;">Uploaded on: <?php echo date('F j, Y, g:i a', strtotime($resume['uploaded_at'])); ?></p>
        
        <div style="display: flex; gap: 15px; justify-content: center;">
            <a href="../assets/images/uploads/resume/<?php echo htmlspecialchars($resume['file_path']); ?>" target="_blank" class="btn-primary" style="text-decoration: none;"><i class="fas fa-eye"></i> View Resume</a>
            <form method="POST" class="delete-form" data-confirm-msg="Delete this resume?">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="btn-danger" style="padding: 12px 24px; font-size: 16px;"><i class="fas fa-trash"></i> Delete</button>
            </form>
        </div>
    <?php else: ?>
        <i class="fas fa-file-upload" style="font-size: 80px; color: #ccc; margin-bottom: 20px;"></i>
        <h3 style="color: #555;">No Resume Uploaded</h3>
        <p style="color: #888; margin-bottom: 30px;">Upload your latest resume in PDF format to feature it on your portfolio.</p>
    <?php endif; ?>

    <hr style="border: 0; border-top: 1px solid #eee; margin: 40px 0;">
    
    <form method="POST" enctype="multipart/form-data" style="text-align: left;">
        <input type="hidden" name="action" value="upload">
        <div class="form-group">
            <label>Upload New Resume (PDF only)</label>
            <input type="file" name="resume" class="form-control" accept=".pdf" required>
        </div>
        <button type="submit" class="btn-primary" style="width: 100%;">Upload Resume</button>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>

