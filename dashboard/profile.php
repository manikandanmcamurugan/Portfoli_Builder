<?php
$page_title = 'My Profile';
require_once '../includes/header.php';

$success = '';
$error = '';
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = trim($_POST['full_name']);
    $headline = trim($_POST['headline']);
    $about = trim($_POST['about']);
    $phone = trim($_POST['phone']);
    $location = trim($_POST['location']);
    $college = trim($_POST['college']);
    $department = trim($_POST['department']);
    $graduation_year = trim($_POST['graduation_year']);
    $linkedin = trim($_POST['linkedin']);
    $github = trim($_POST['github']);
    $website = trim($_POST['website']);
    
    // Handle File Upload
    $profile_photo = $profile['profile_photo']; // default to existing
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $filename = $_FILES['photo']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            if ($_FILES['photo']['size'] < 2000000) { // 2MB max
                $new_filename = uniqid() . '.' . $ext;
                $dest = '../assets/images/uploads/profile/' . $new_filename;
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $dest)) {
                    $profile_photo = $new_filename;
                } else {
                    $error = "Failed to upload image.";
                }
            } else {
                $error = "File too large (Max 2MB).";
            }
        } else {
            $error = "Invalid file type. Allowed: JPG, PNG, WEBP.";
        }
    }
    
    if (empty($error)) {
        $stmt = $pdo->prepare("
            UPDATE profiles SET 
                full_name = ?, profile_photo = ?, headline = ?, about = ?, phone = ?, 
                location = ?, college = ?, department = ?, graduation_year = ?, 
                linkedin = ?, github = ?, website = ?
            WHERE user_id = ?
        ");
        if ($stmt->execute([
            $full_name, $profile_photo, $headline, $about, $phone, 
            $location, $college, $department, $graduation_year, 
            $linkedin, $github, $website, $user_id
        ])) {
            $success = "Profile updated successfully!";
            // refresh data
            $stmt = $pdo->prepare("SELECT * FROM profiles WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $profile = $stmt->fetch();
        } else {
            $error = "Failed to update profile.";
        }
    }
}
?>

<h1 class="page-title">Manage Profile</h1>

<?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>
<?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>

<div class="form-container">
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group" style="text-align: center; margin-bottom: 30px;">
            <?php if(!empty($profile['profile_photo'])): ?>
                <img src="../assets/images/uploads/profile/<?php echo htmlspecialchars($profile['profile_photo']); ?>" alt="Profile" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 15px; border: 3px solid var(--primary);">
            <?php else: ?>
                <div style="width: 120px; height: 120px; border-radius: 50%; background: #eee; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 40px; color: #aaa;"><i class="fas fa-user"></i></div>
            <?php endif; ?>
            <label>Profile Photo (JPG, PNG - Max 2MB)</label>
            <input type="file" name="photo" class="form-control" accept="image/*" style="max-width: 300px; margin: 0 auto;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>Full Name *</label>
                <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($profile['full_name'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label>Professional Headline </label>
                <input type="text" name="headline" class="form-control" value="<?php echo htmlspecialchars($profile['headline'] ?? ''); ?>">
            </div>
        </div>

        <div class="form-group">
            <label>About Me</label>
            <textarea name="about" class="form-control" rows="5"><?php echo htmlspecialchars($profile['about'] ?? ''); ?></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($profile['phone'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Location (City, Country)</label>
                <input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($profile['location'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>College/University</label>
                <input type="text" name="college" class="form-control" value="<?php echo htmlspecialchars($profile['college'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Department/Major</label>
                <input type="text" name="department" class="form-control" value="<?php echo htmlspecialchars($profile['department'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Graduation Year</label>
                <input type="number" name="graduation_year" class="form-control" value="<?php echo htmlspecialchars($profile['graduation_year'] ?? ''); ?>">
            </div>
        </div>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">
        <h3 style="margin-top:0;">Social Links</h3>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>LinkedIn URL</label>
                <input type="url" name="linkedin" class="form-control" value="<?php echo htmlspecialchars($profile['linkedin'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>GitHub URL</label>
                <input type="url" name="github" class="form-control" value="<?php echo htmlspecialchars($profile['github'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Personal Website</label>
                <input type="url" name="website" class="form-control" value="<?php echo htmlspecialchars($profile['website'] ?? ''); ?>">
            </div>
        </div>

        <button type="submit" class="btn-primary" style="margin-top: 20px;">Save Profile</button>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>
