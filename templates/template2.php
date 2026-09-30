<?php
// Ensure this file is loaded within portfolio/view.php where data variables are available.
// Variables available: $profile, $skills, $projects, $user_id (plus we will fetch education here)

// Fetch education since it wasn't fetched in the main view.php yet
$stmt = $pdo->prepare("SELECT * FROM education WHERE user_id = ? ORDER BY start_year DESC");
$stmt->execute([$user_id]);
$education = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($profile['full_name']); ?> - Resume / Professional</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary: #2c3e50; --secondary: #34495e; --accent: #3498db; --bg: #f5f6fa; --text: #2f3640; --light: #ffffff; }
        body { margin: 0; font-family: 'Roboto', sans-serif; background: var(--bg); color: var(--text); line-height: 1.6; }
        .container { max-width: 1000px; margin: 40px auto; background: var(--light); box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; display: flex; flex-wrap: wrap; }
        
        /* Left Sidebar */
        .sidebar { background: var(--primary); color: #ecf0f1; width: 300px; padding: 40px 30px; box-sizing: border-box; }
        .profile-img { width: 180px; height: 180px; border-radius: 50%; object-fit: cover; border: 4px solid var(--accent); margin: 0 auto 20px; display: block; }
        .sidebar-title { font-size: 18px; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid var(--accent); padding-bottom: 10px; margin-bottom: 20px; margin-top: 40px; color: #bdc3c7; }
        .contact-item { display: flex; align-items: center; margin-bottom: 15px; font-size: 14px; }
        .contact-item i { width: 30px; color: var(--accent); font-size: 18px; }
        .contact-item a { color: #ecf0f1; text-decoration: none; }
        .contact-item a:hover { color: var(--accent); }
        
        .skill-bar-container { margin-bottom: 15px; }
        .skill-name { font-size: 14px; margin-bottom: 5px; display: block; }
        .skill-bar { width: 100%; height: 6px; background: rgba(255,255,255,0.1); border-radius: 3px; overflow: hidden; }
        .skill-progress { height: 100%; background: var(--accent); }
        
        /* Main Content */
        .main-content { flex: 1; padding: 50px; box-sizing: border-box; min-width: 300px; }
        .name { font-size: 46px; font-weight: 700; color: var(--primary); margin: 0; line-height: 1.1; }
        .headline { font-size: 22px; color: var(--accent); font-weight: 300; margin-top: 10px; margin-bottom: 30px; }
        .about { font-size: 15px; color: #555; text-align: justify; margin-bottom: 40px; }
        
        .section-header { font-size: 24px; color: var(--primary); font-weight: 700; text-transform: uppercase; margin-bottom: 25px; display: flex; align-items: center; }
        .section-header i { margin-right: 15px; color: var(--accent); }
        
        .timeline-item { margin-bottom: 30px; position: relative; padding-left: 20px; border-left: 2px solid #ecf0f1; }
        .timeline-item::before { content: ''; position: absolute; left: -7px; top: 5px; width: 12px; height: 12px; background: var(--accent); border-radius: 50%; }
        .timeline-title { font-size: 18px; font-weight: 700; color: var(--primary); margin: 0; }
        .timeline-subtitle { font-size: 15px; font-weight: 500; color: var(--secondary); margin: 5px 0; }
        .timeline-date { font-size: 13px; color: #7f8c8d; font-weight: 500; display: inline-block; background: #ecf0f1; padding: 2px 8px; border-radius: 4px; margin-bottom: 10px; }
        .timeline-desc { font-size: 14px; color: #555; margin: 0; }
        
        .project-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .proj-card { border: 1px solid #eee; padding: 20px; border-radius: 6px; }
        .proj-card h4 { margin: 0 0 10px 0; color: var(--primary); font-size: 16px; }
        .proj-tech { font-size: 12px; color: var(--accent); font-weight: 500; margin-bottom: 10px; display: block; }
        .proj-desc { font-size: 13px; color: #666; margin-bottom: 15px; }
        
        @media (max-width: 768px) {
            .container { margin: 0; border-radius: 0; }
            .sidebar { width: 100%; padding: 30px; }
            .main-content { padding: 30px; }
            .project-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="sidebar">
        <?php if(!empty($profile['profile_photo'])): ?>
            <img src="../assets/images/uploads/profile/<?php echo htmlspecialchars($profile['profile_photo']); ?>" alt="Profile" class="profile-img">
        <?php else: ?>
            <div class="profile-img" style="background: var(--secondary); display: flex; align-items: center; justify-content: center; font-size: 80px; color: #fff;"><i class="fas fa-user"></i></div>
        <?php endif; ?>
        
        <h3 class="sidebar-title">Contact</h3>
        <?php if(!empty($profile['phone'])): ?>
            <div class="contact-item"><i class="fas fa-phone"></i> <?php echo htmlspecialchars($profile['phone']); ?></div>
        <?php endif; ?>
        <?php if(!empty($profile['location'])): ?>
            <div class="contact-item"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($profile['location']); ?></div>
        <?php endif; ?>
        <?php if(!empty($profile['linkedin'])): ?>
            <div class="contact-item"><i class="fab fa-linkedin"></i> <a href="<?php echo htmlspecialchars($profile['linkedin']); ?>" target="_blank">LinkedIn Profile</a></div>
        <?php endif; ?>
        <?php if(!empty($profile['github'])): ?>
            <div class="contact-item"><i class="fab fa-github"></i> <a href="<?php echo htmlspecialchars($profile['github']); ?>" target="_blank">GitHub Profile</a></div>
        <?php endif; ?>
        
        <?php if(!empty($skills)): ?>
            <h3 class="sidebar-title">Expertise</h3>
            <?php foreach($skills as $s): 
                $pct = 25;
                if($s['skill_level'] == 'Intermediate') $pct = 50;
                if($s['skill_level'] == 'Advanced') $pct = 75;
                if($s['skill_level'] == 'Expert') $pct = 100;
            ?>
                <div class="skill-bar-container">
                    <span class="skill-name"><?php echo htmlspecialchars($s['skill_name']); ?> (<?php echo $s['skill_level']; ?>)</span>
                    <div class="skill-bar"><div class="skill-progress" style="width: <?php echo $pct; ?>%;"></div></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <div class="main-content">
        <h1 class="name"><?php echo htmlspecialchars($profile['full_name']); ?></h1>
        <h2 class="headline"><?php echo htmlspecialchars($profile['headline'] ?? ''); ?></h2>
        
        <?php if(!empty($profile['about'])): ?>
            <p class="about"><?php echo nl2br(htmlspecialchars($profile['about'])); ?></p>
        <?php endif; ?>
        
        <?php if(!empty($education)): ?>
            <div class="section-header"><i class="fas fa-graduation-cap"></i> Education</div>
            <?php foreach($education as $e): ?>
                <div class="timeline-item">
                    <h3 class="timeline-title"><?php echo htmlspecialchars($e['degree']); ?></h3>
                    <h4 class="timeline-subtitle"><?php echo htmlspecialchars($e['college']); ?></h4>
                    <div class="timeline-date"><?php echo htmlspecialchars($e['start_year']); ?> - <?php echo $e['end_year'] ? htmlspecialchars($e['end_year']) : 'Present'; ?></div>
                    <?php if($e['cgpa'] || $e['percentage']): ?>
                        <p class="timeline-desc"><strong>Score:</strong> <?php echo $e['cgpa'] ? htmlspecialchars($e['cgpa']).' CGPA' : htmlspecialchars($e['percentage']).'%'; ?></p>
                    <?php endif; ?>
                    <?php if($e['description']): ?>
                        <p class="timeline-desc"><?php echo htmlspecialchars($e['description']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <?php if(!empty($projects)): ?>
            <div class="section-header" style="margin-top: 40px;"><i class="fas fa-project-diagram"></i> Projects</div>
            <div class="project-grid">
                <?php foreach($projects as $p): ?>
                    <div class="proj-card">
                        <h4><?php echo htmlspecialchars($p['title']); ?></h4>
                        <span class="proj-tech"><?php echo htmlspecialchars($p['technologies']); ?></span>
                        <p class="proj-desc"><?php echo htmlspecialchars($p['description']); ?></p>
                        <div style="display: flex; gap: 10px;">
                            <?php if($p['github_url']): ?><a href="<?php echo htmlspecialchars($p['github_url']); ?>" target="_blank" style="color: var(--primary); text-decoration: none; font-size: 13px;"><i class="fab fa-github"></i> Source</a><?php endif; ?>
                            <?php if($p['demo_url']): ?><a href="<?php echo htmlspecialchars($p['demo_url']); ?>" target="_blank" style="color: var(--accent); text-decoration: none; font-size: 13px;"><i class="fas fa-link"></i> Live Demo</a><?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
