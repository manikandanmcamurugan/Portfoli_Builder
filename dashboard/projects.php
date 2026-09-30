<?php
$page_title = 'My Projects';
require_once '../includes/header.php';

$success = '';
$error = '';
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'add') {
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $technologies = trim($_POST['technologies']);
        $github_url = trim($_POST['github_url']);
        $demo_url = trim($_POST['demo_url']);
        
        $image = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                $image = uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], '../assets/images/uploads/projects/' . $image);
            }
        }
        
        if (empty($title) || empty($description) || empty($technologies)) {
            $error = "Title, Description, and Technologies are required.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO projects (user_id, title, description, technologies, image, github_url, demo_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$user_id, $title, $description, $technologies, $image, $github_url, $demo_url])) {
                $success = "Project added successfully.";
            }
        }
    } elseif (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $id = $_POST['id'];
        // Get image to delete
        $stmt = $pdo->prepare("SELECT image FROM projects WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $user_id]);
        $proj = $stmt->fetch();
        if ($proj && $proj['image']) {
            @unlink('../assets/images/uploads/projects/' . $proj['image']);
        }
        
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ? AND user_id = ?");
        if ($stmt->execute([$id, $user_id])) {
            $success = "Project deleted successfully.";
        }
    }
}

$stmt = $pdo->prepare("SELECT * FROM projects WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$projects = $stmt->fetchAll();
?>

<h1 class="page-title">Manage Projects</h1>

<?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>
<?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>

<div style="display: flex; gap: 30px; align-items: flex-start; flex-wrap: wrap;">
    <!-- Add Form -->
    <div class="form-container" style="flex: 1; min-width: 300px; margin: 0;">
        <h3 style="margin-top: 0;">Add New Project</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label>Project Title *</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Technologies Used *</label>
                <input type="text" name="technologies" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Description *</label>
                <textarea name="description" class="form-control" required rows="4"></textarea>
            </div>
            <div class="form-group">
                <label>Project Image (JPG, PNG)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="form-group">
                <label>GitHub URL</label>
                <input type="url" name="github_url" class="form-control">
            </div>
            <div class="form-group">
                <label>Live Demo URL</label>
                <input type="url" name="demo_url" class="form-control">
            </div>
            <button type="submit" class="btn-primary">Add Project</button>
        </form>
    </div>

    <!-- Project List -->
    <div style="flex: 2; min-width: 300px;">
        <?php if(empty($projects)): ?>
            <div class="card"><p>No projects added yet.</p></div>
        <?php else: ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
                <?php foreach($projects as $p): ?>
                    <div class="card" style="padding: 0; overflow: hidden;">
                        <?php if($p['image']): ?>
                            <img src="../assets/images/uploads/projects/<?php echo htmlspecialchars($p['image']); ?>" style="width: 100%; height: 180px; object-fit: cover; border-bottom: 1px solid #eee;">
                        <?php else: ?>
                            <div style="width: 100%; height: 180px; background: #eee; display: flex; align-items: center; justify-content: center; color: #aaa;"><i class="fas fa-image fa-3x"></i></div>
                        <?php endif; ?>
                        <div style="padding: 20px;">
                            <h4 style="margin: 0 0 10px 0;"><?php echo htmlspecialchars($p['title']); ?></h4>
                            <p style="font-size: 13px; color: #666; margin: 0 0 15px 0;"><strong>Tech:</strong> <?php echo htmlspecialchars($p['technologies']); ?></p>
                            <p style="font-size: 14px; color: #444; margin: 0 0 20px 0;"><?php echo substr(htmlspecialchars($p['description']), 0, 100) . '...'; ?></p>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <?php if($p['github_url']): ?><a href="<?php echo htmlspecialchars($p['github_url']); ?>" target="_blank" title="GitHub"><i class="fab fa-github" style="color:#333; font-size:20px;"></i></a><?php endif; ?>
                                    <?php if($p['demo_url']): ?><a href="<?php echo htmlspecialchars($p['demo_url']); ?>" target="_blank" title="Demo" style="margin-left:10px;"><i class="fas fa-external-link-alt" style="color:#0066ff; font-size:18px;"></i></a><?php endif; ?>
                                </div>
                                <form method="POST" class="delete-form" data-confirm-msg="Delete this project?">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                    <button type="submit" class="btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
