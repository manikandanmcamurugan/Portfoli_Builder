<?php
$page_title = 'Dashboard';
require_once '../includes/header.php';

$user_id = $_SESSION['user_id'];
$first_name = explode(' ', $_SESSION['name'])[0];

// Calculate completion
$completion = 10; 
$has_profile = $has_edu = $has_skills = $has_proj = $has_cert = $has_resume = $has_ach = false;

if(!empty($profile['headline']) || !empty($profile['about'])) { $completion += 15; $has_profile = true; }
if(!empty($profile['profile_photo'])) { $completion += 5; }

$stmt = $pdo->prepare("SELECT COUNT(*) FROM skills WHERE user_id = ?"); $stmt->execute([$user_id]); $skills_count = $stmt->fetchColumn();
if($skills_count > 0) { $completion += 15; $has_skills = true; }

$stmt = $pdo->prepare("SELECT COUNT(*) FROM projects WHERE user_id = ?"); $stmt->execute([$user_id]); $projects_count = $stmt->fetchColumn();
if($projects_count > 0) { $completion += 20; $has_proj = true; }

$stmt = $pdo->prepare("SELECT COUNT(*) FROM certificates WHERE user_id = ?"); $stmt->execute([$user_id]); $certs_count = $stmt->fetchColumn();
if($certs_count > 0) { $completion += 10; $has_cert = true; }

$stmt = $pdo->prepare("SELECT COUNT(*) FROM education WHERE user_id = ?"); $stmt->execute([$user_id]); $edu_count = $stmt->fetchColumn();
if($edu_count > 0) { $completion += 15; $has_edu = true; }

$stmt = $pdo->prepare("SELECT COUNT(*) FROM resumes WHERE user_id = ?"); $stmt->execute([$user_id]);
if($stmt->fetchColumn() > 0) { $completion += 10; $has_resume = true; }

$stmt = $pdo->prepare("SELECT COUNT(*) FROM achievements WHERE user_id = ?"); $stmt->execute([$user_id]);
if($stmt->fetchColumn() > 0) { $completion += 5; $has_ach = true; }

$completion = min($completion, 100);

// Fetch recent projects
$stmt = $pdo->prepare("SELECT * FROM projects WHERE user_id = ? ORDER BY id DESC LIMIT 5");
$stmt->execute([$user_id]);
$recent_projects = $stmt->fetchAll();

// Fetch recent achievements
$stmt = $pdo->prepare("SELECT * FROM achievements WHERE user_id = ? ORDER BY id DESC LIMIT 5");
$stmt->execute([$user_id]);
$recent_achievements = $stmt->fetchAll();

// Fetch current template info
$stmt = $pdo->prepare("
    SELECT t.name, t.preview_image, t.id
    FROM portfolio_settings ps
    JOIN templates t ON ps.template_id = t.id
    WHERE ps.user_id = ?
");
$stmt->execute([$user_id]);
$current_template = $stmt->fetch();
?>

<?php if($completion < 100): ?>
<div class="alert alert-warning">
    <i class="fas fa-exclamation-triangle"></i>
    <div>
        <strong>Complete Your Profile</strong><br>
        Your portfolio is <?php echo $completion; ?>% complete. Add your resume and projects to improve your portfolio.
    </div>
</div>
<?php endif; ?>

<!-- Welcome Section -->
<div class="card welcome-card">
    <div class="welcome-content">
        <h1>Good Morning, <?php echo htmlspecialchars($first_name); ?> ??</h1>
        <p>Build your professional identity, customize your portfolio template, and showcase your achievements to the world.</p>
        <div class="welcome-actions">
            <a href="<?php echo $portfolio_url; ?>" target="_blank" class="btn btn-light"><i class="fas fa-eye"></i> View Portfolio</a>
            <a href="projects.php" class="btn btn-outline" style="border-color: rgba(255,255,255,0.3); color: white;"><i class="fas fa-plus"></i> Add Project</a>
        </div>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-4" style="margin-bottom: 24px;">
    <div class="card stat-card">
        <div>
            <div class="stat-icon projects"><i class="fas fa-project-diagram"></i></div>
            <div class="stat-value"><?php echo $projects_count; ?></div>
            <div class="stat-label">Projects</div>
        </div>
        <div class="stat-trend up"><i class="fas fa-arrow-up"></i> +1 this month</div>
    </div>
    
    <div class="card stat-card">
        <div>
            <div class="stat-icon skills"><i class="fas fa-star"></i></div>
            <div class="stat-value"><?php echo $skills_count; ?></div>
            <div class="stat-label">Skills</div>
        </div>
        <div class="stat-trend up"><i class="fas fa-arrow-up"></i> Active</div>
    </div>
    
    <div class="card stat-card">
        <div>
            <div class="stat-icon certs"><i class="fas fa-certificate"></i></div>
            <div class="stat-value"><?php echo $certs_count; ?></div>
            <div class="stat-label">Certificates</div>
        </div>
        <div class="stat-trend neutral"><i class="fas fa-minus"></i> Stable</div>
    </div>
    
    <div class="card stat-card">
        <div>
            <div class="stat-icon views"><i class="fas fa-eye"></i></div>
            <div class="stat-value">245</div>
            <div class="stat-label">Portfolio Views</div>
        </div>
        <div class="stat-trend up"><i class="fas fa-arrow-up"></i> +18% this month</div>
    </div>
</div>

<!-- Completion & Actions -->
<div class="dash-layout">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Portfolio Completion</h3>
            <span class="status-badge status-completed"><?php echo $completion; ?>%</span>
        </div>
        <div class="progress-container">
            <div class="progress-bar" style="width: <?php echo $completion; ?>%;"></div>
        </div>
        <div class="completion-list">
            <div class="completion-item">Profile <span><i class="<?php echo $has_profile ? 'fas fa-check-circle' : 'far fa-circle'; ?>"></i></span></div>
            <div class="completion-item">Education <span><i class="<?php echo $has_edu ? 'fas fa-check-circle' : 'far fa-circle'; ?>"></i></span></div>
            <div class="completion-item">Skills <span><i class="<?php echo $has_skills ? 'fas fa-check-circle' : 'far fa-circle'; ?>"></i></span></div>
            <div class="completion-item">Projects <span><i class="<?php echo $has_proj ? 'fas fa-check-circle' : 'far fa-circle'; ?>"></i></span></div>
            <div class="completion-item">Certificates <span><i class="<?php echo $has_cert ? 'fas fa-check-circle' : 'far fa-circle'; ?>"></i></span></div>
            <div class="completion-item">Resume <span><i class="<?php echo $has_resume ? 'fas fa-check-circle' : 'far fa-circle'; ?>"></i></span></div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Quick Actions</h3>
        </div>
        <div class="quick-actions">
            <a href="projects.php" class="action-btn"><i class="fas fa-folder-plus"></i> Add Project</a>
            <a href="certificates.php" class="action-btn"><i class="fas fa-award"></i> Add Cert</a>
            <a href="profile.php" class="action-btn"><i class="fas fa-user-edit"></i> Edit Profile</a>
            <a href="templates.php" class="action-btn"><i class="fas fa-paint-brush"></i> Themes</a>
        </div>
    </div>
</div>

<!-- Template & Profile -->
<div class="dash-layout">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Current Template</h3>
        </div>
        <?php if($current_template): ?>
            <div class="template-preview" style="background-image: url('../assets/images/uploads/templates/<?php echo $current_template['preview_image'] ? htmlspecialchars($current_template['preview_image']) : 'modern.png'; ?>');"></div>
            <div class="template-info">
                <div>
                    <div class="template-name"><?php echo htmlspecialchars(ucfirst($current_template['name'])); ?> Template</div>
                    <div class="template-date">Last updated: Recently</div>
                </div>
                <div>
                    <a href="settings.php" class="btn btn-outline btn-sm">Customize</a>
                    <a href="templates.php" class="btn btn-primary btn-sm">Change</a>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-state" style="padding: 20px;">
                <i class="fas fa-paint-roller empty-icon" style="font-size: 32px;"></i>
                <h4>No Template Selected</h4>
                <p>Choose a template to start building your portfolio.</p>
                <a href="templates.php" class="btn btn-primary">Choose Template</a>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="card profile-overview">
        <div class="card-header" style="justify-content: center;">
            <h3 class="card-title">Profile Overview</h3>
        </div>
        <?php if(!empty($profile['profile_photo'])): ?>
            <img src="../assets/images/uploads/profile/<?php echo htmlspecialchars($profile['profile_photo']); ?>" alt="Profile" class="avatar-large">
        <?php else: ?>
            <div class="avatar-placeholder"><?php echo strtoupper(substr($_SESSION['name'], 0, 1)); ?></div>
        <?php endif; ?>
        
        <h3><?php echo htmlspecialchars($_SESSION['name']); ?></h3>
        <div class="title"><?php echo $profile['headline'] ? htmlspecialchars($profile['headline']) : 'Student'; ?></div>
        
        <div class="profile-details">
            <div class="profile-detail-item"><i class="fas fa-envelope"></i> <?php echo $profile['email'] ?? 'Not provided'; ?></div>
            <div class="profile-detail-item"><i class="fas fa-building"></i> <?php echo $profile['department'] ? htmlspecialchars($profile['department']) : 'Department not set'; ?></div>
            <div class="profile-detail-item"><i class="fas fa-graduation-cap"></i> <?php echo $profile['college'] ? htmlspecialchars($profile['college']) : 'College not set'; ?></div>
        </div>
        <a href="profile.php" class="btn btn-outline" style="width: 100%; margin-top: 15px;">Edit Profile</a>
    </div>
</div>

<!-- Recent Projects -->
<div class="card" style="margin-bottom: 24px;">
    <div class="card-header">
        <h3 class="card-title">Recent Projects</h3>
        <a href="projects.php" class="btn btn-outline btn-sm">View All ?</a>
    </div>
    
    <?php if(count($recent_projects) > 0): ?>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Project</th>
                    <th>Technology</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($recent_projects as $p): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($p['title']); ?></strong></td>
                    <td><?php echo htmlspecialchars($p['technologies']); ?></td>
                    <td><span class="status-badge status-completed">Completed</span></td>
                    <td>
                        <a href="projects.php?edit=<?php echo $p['id']; ?>" class="btn btn-outline btn-sm">Edit</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="empty-state">
        <i class="fas fa-folder-open empty-icon"></i>
        <h3>No projects added yet</h3>
        <p>Showcase your work by adding your first project.</p>
        <a href="projects.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Project</a>
    </div>
    <?php endif; ?>
</div>

<!-- Analytics & Achievements -->
<div class="dash-layout">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Portfolio Analytics</h3>
        </div>
        <!-- Mock visual representation of a chart using pure CSS -->
        <div style="height: 200px; display: flex; align-items: flex-end; justify-content: space-between; padding-top: 40px; border-bottom: 1px solid var(--border-color); position: relative;">
            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; display: flex; flex-direction: column; justify-content: space-between; pointer-events: none;">
                <div style="border-bottom: 1px dashed var(--border-color); height: 1px;"></div>
                <div style="border-bottom: 1px dashed var(--border-color); height: 1px;"></div>
                <div style="border-bottom: 1px dashed var(--border-color); height: 1px;"></div>
                <div style="border-bottom: 1px dashed var(--border-color); height: 1px;"></div>
            </div>
            <div style="width: 12%; background: var(--primary-light); height: 30%; border-radius: 4px 4px 0 0; position: relative; z-index: 1;"></div>
            <div style="width: 12%; background: var(--primary-light); height: 45%; border-radius: 4px 4px 0 0; position: relative; z-index: 1;"></div>
            <div style="width: 12%; background: var(--primary-light); height: 25%; border-radius: 4px 4px 0 0; position: relative; z-index: 1;"></div>
            <div style="width: 12%; background: var(--primary-light); height: 60%; border-radius: 4px 4px 0 0; position: relative; z-index: 1;"></div>
            <div style="width: 12%; background: var(--primary); height: 85%; border-radius: 4px 4px 0 0; position: relative; z-index: 1;"></div>
            <div style="width: 12%; background: var(--primary-light); height: 50%; border-radius: 4px 4px 0 0; position: relative; z-index: 1;"></div>
            <div style="width: 12%; background: var(--primary-light); height: 75%; border-radius: 4px 4px 0 0; position: relative; z-index: 1;"></div>
        </div>
        <div style="display: flex; justify-content: space-between; color: var(--text-muted); font-size: 12px; margin-top: 10px;">
            <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Recent Achievements</h3>
        </div>
        <?php if(count($recent_achievements) > 0): ?>
            <div class="timeline">
                <?php foreach($recent_achievements as $ach): ?>
                <div class="timeline-item">
                    <div class="timeline-icon"></div>
                    <div class="timeline-content">
                        <h4><?php echo htmlspecialchars($ach['title']); ?></h4>
                        <div class="timeline-date">Awarded by <?php echo htmlspecialchars($ach['issuer']); ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state" style="padding: 20px;">
                <i class="fas fa-trophy empty-icon" style="font-size: 32px;"></i>
                <p>No achievements added yet.</p>
                <a href="achievements.php" class="btn btn-outline btn-sm">Add Achievement</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Share Card -->
<div class="card share-card" style="margin-bottom: 24px;">
    <h2>?? Your Portfolio is Ready!</h2>
    <p style="color: #94a3b8; font-size: 16px; margin-bottom: 0;">Share your professional portfolio with recruiters, companies and friends.</p>
    
    <div class="share-url" id="portfolioUrl">
        <?php echo htmlspecialchars($portfolio_url); ?>
    </div>
    
    <div>
        <button class="btn btn-primary" onclick="navigator.clipboard.writeText('<?php echo htmlspecialchars($portfolio_url); ?>'); alert('Copied to clipboard!')"><i class="far fa-copy"></i> Copy Link</button>
        <a href="<?php echo htmlspecialchars($portfolio_url); ?>" target="_blank" class="btn btn-outline" style="border-color: rgba(255,255,255,0.3); color: white;"><i class="far fa-eye"></i> View Portfolio</a>
    </div>
</div>

<script>
    // Handle mobile sidebar click outside
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const toggle = document.querySelector('.menu-toggle');
        
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
</script>

<?php require_once '../includes/footer.php'; ?>

