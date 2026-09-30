<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($profile['full_name']); ?> - Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --accent: #00e5ff; --bg: #0f172a; --text: #f8fafc; --card: #1e293b; }
        body { margin: 0; font-family: 'Poppins', sans-serif; background: var(--bg); color: var(--text); }
        .container { max-width: 1100px; margin: 0 auto; padding: 0 20px; }
        
        header { padding: 40px 0; display: flex; justify-content: space-between; align-items: center; }
        .socials a { color: var(--text); font-size: 24px; margin-left: 15px; transition: color 0.3s; }
        .socials a:hover { color: var(--accent); }
        
        .hero { display: flex; align-items: center; justify-content: space-between; padding: 80px 0; }
        .hero-text h1 { font-size: 60px; margin: 0; line-height: 1.2; }
        .hero-text h1 span { color: var(--accent); }
        .hero-text h2 { font-weight: 300; color: #94a3b8; font-size: 24px; margin-top: 10px; }
        .hero-text p { font-size: 16px; color: #cbd5e1; max-width: 500px; margin: 20px 0; line-height: 1.8; }
        .hero-img { width: 300px; height: 300px; border-radius: 50%; object-fit: cover; border: 5px solid var(--card); box-shadow: 0 0 40px rgba(0, 229, 255, 0.2); }
        
        .section-title { font-size: 32px; margin-bottom: 40px; text-transform: uppercase; letter-spacing: 2px; }
        .section-title span { color: var(--accent); }
        
        .skills-grid { display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 80px; }
        .skill-badge { background: var(--card); padding: 10px 20px; border-radius: 30px; font-weight: 600; border: 1px solid #334155; }
        
        .projects-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 30px; margin-bottom: 80px; }
        .project-card { background: var(--card); border-radius: 16px; overflow: hidden; transition: transform 0.3s; border: 1px solid #334155; }
        .project-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.4); }
        .project-img { width: 100%; height: 200px; object-fit: cover; }
        .project-info { padding: 25px; }
        .project-info h3 { margin: 0 0 10px 0; font-size: 22px; }
        .project-info p { color: #94a3b8; font-size: 14px; margin-bottom: 20px; line-height: 1.6; }
        .project-links a { display: inline-block; padding: 8px 20px; background: rgba(255,255,255,0.1); color: #fff; text-decoration: none; border-radius: 8px; margin-right: 10px; font-size: 14px; transition: 0.3s; }
        .project-links a:hover { background: var(--accent); color: var(--bg); }
        
        footer { text-align: center; padding: 40px 0; border-top: 1px solid #334155; margin-top: 50px; color: #64748b; }
        
        @media (max-width: 768px) {
            .hero { flex-direction: column-reverse; text-align: center; }
            .hero-img { margin-bottom: 40px; }
        }
    </style>
<style>
    :root {
        --primary-color: #ffb7c5;
        --secondary-color: #ffb7c5;
        --text-color: #333333;
        --bg-color: #ffffff;
    }
    body { background-color: var(--bg-color); color: var(--text-color); }
    .card { background-color: #f9f9f9 !important; }
    header, footer { background-color: #f9f9f9 !important; border-color: #ffb7c5 !important; }
    </style>
</head>
<body>

<div class="container">
    <header>
        <div style="font-size: 24px; font-weight: 700; letter-spacing: 2px;">
            <?php echo strtoupper(explode(' ', $profile['full_name'])[0]); ?><span style="color: var(--accent);">.</span>
        </div>
        <div class="socials">
            <?php if(!empty($profile['github'])): ?><a href="<?php echo htmlspecialchars($profile['github']); ?>" target="_blank"><i class="fab fa-github"></i></a><?php endif; ?>
            <?php if(!empty($profile['linkedin'])): ?><a href="<?php echo htmlspecialchars($profile['linkedin']); ?>" target="_blank"><i class="fab fa-linkedin"></i></a><?php endif; ?>
            <?php if(!empty($profile['website'])): ?><a href="<?php echo htmlspecialchars($profile['website']); ?>" target="_blank"><i class="fas fa-globe"></i></a><?php endif; ?>
        </div>
    </header>

    <section class="hero">
        <div class="hero-text">
            <h2>Hello, I'm</h2>
            <h1><?php echo htmlspecialchars($profile['full_name']); ?></h1>
            <h2 style="color: var(--accent);"><?php echo htmlspecialchars($profile['headline'] ?? ''); ?></h2>
            <p><?php echo htmlspecialchars($profile['about'] ?? ''); ?></p>
        </div>
        <?php if(!empty($profile['profile_photo'])): ?>
            <img src="../assets/images/uploads/profile/<?php echo htmlspecialchars($profile['profile_photo']); ?>" alt="Profile" class="hero-img">
        <?php else: ?>
            <div class="hero-img" style="background: #1e293b; display: flex; align-items: center; justify-content: center; font-size: 80px; color: #334155;"><i class="fas fa-user"></i></div>
        <?php endif; ?>
    </section>

    <?php if(!empty($skills)): ?>
    <section>
        <h2 class="section-title">My <span>Skills</span></h2>
        <div class="skills-grid">
            <?php foreach($skills as $s): ?>
                <div class="skill-badge"><?php echo htmlspecialchars($s['skill_name']); ?></div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if(!empty($projects)): ?>
    <section>
        <h2 class="section-title">Selected <span>Works</span></h2>
        <div class="projects-grid">
            <?php foreach($projects as $p): ?>
                <div class="project-card">
                    <?php if($p['image']): ?>
                        <img src="../assets/images/uploads/projects/<?php echo htmlspecialchars($p['image']); ?>" class="project-img">
                    <?php else: ?>
                        <div class="project-img" style="background: #334155; display: flex; align-items: center; justify-content: center; color: #64748b;"><i class="fas fa-image fa-3x"></i></div>
                    <?php endif; ?>
                    <div class="project-info">
                        <h3><?php echo htmlspecialchars($p['title']); ?></h3>
                        <p style="color: var(--accent); font-weight: 600; font-size: 12px; text-transform: uppercase;"><?php echo htmlspecialchars($p['technologies']); ?></p>
                        <p><?php echo htmlspecialchars($p['description']); ?></p>
                        <div class="project-links">
                            <?php if($p['github_url']): ?><a href="<?php echo htmlspecialchars($p['github_url']); ?>" target="_blank"><i class="fab fa-github"></i> Code</a><?php endif; ?>
                            <?php if($p['demo_url']): ?><a href="<?php echo htmlspecialchars($p['demo_url']); ?>" target="_blank"><i class="fas fa-external-link-alt"></i> Live Demo</a><?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

</div>

    <?php if(!empty($education)): ?>
    <section>
        <h2 class="section-title">My <span>Education</span></h2>
        <div class="projects-grid">
            <?php foreach($education as $e): ?>
                <div class="project-card" style="padding: 25px;">
                    <h3 style="margin-top:0; font-size: 20px;"><?php echo htmlspecialchars($e['degree'] ?? ''); ?></h3>
                    <p style="color: var(--accent); font-weight: bold; margin-bottom:5px; margin-top:5px;"><?php echo htmlspecialchars($e['college'] ?? ''); ?></p>
                    <p style="color: #94a3b8; font-size: 14px; margin-top:0;"><?php echo htmlspecialchars($e['end_year'] ?? ''); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if(!empty($internships)): ?>
    <section>
        <h2 class="section-title">My <span>Internships</span></h2>
        <div class="projects-grid">
            <?php foreach($internships as $i): ?>
                <div class="project-card" style="padding: 25px;">
                    <h3 style="margin-top:0; font-size: 20px;"><?php echo htmlspecialchars($i['role'] ?? ''); ?></h3>
                    <p style="color: var(--accent); font-weight: bold; margin-bottom:5px; margin-top:5px;"><?php echo htmlspecialchars($i['company'] ?? ''); ?></p>
                    <p style="color: #94a3b8; font-size: 14px; margin-top:0;"><?php echo htmlspecialchars($i['start_date'] ?? '') . ' to ' . htmlspecialchars($i['end_date'] ?? ''); ?></p>
                    <p style="font-size: 14px;"><?php echo htmlspecialchars($i['description'] ?? ''); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if(!empty($hackathons)): ?>
    <section>
        <h2 class="section-title">My <span>Hackathons</span></h2>
        <div class="projects-grid">
            <?php foreach($hackathons as $h): ?>
                <div class="project-card" style="padding: 25px;">
                    <h3 style="margin-top:0; font-size: 20px;"><?php echo htmlspecialchars($h['hackathon_name'] ?? ''); ?></h3>
                    <p style="color: var(--accent); font-weight: bold; margin-bottom:5px; margin-top:5px;"><?php echo htmlspecialchars($h['project_title'] ?? ''); ?></p>
                    <p style="color: #94a3b8; font-size: 14px; margin-top:0;"><?php echo htmlspecialchars($h['date'] ?? ''); ?></p>
                    <p style="font-size: 14px;"><?php echo htmlspecialchars($h['description'] ?? ''); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if(!empty($certificates) || !empty($achievements)): ?>
    <section>
        <h2 class="section-title">My <span>Certifications & Achievements</span></h2>
        <div class="projects-grid">
            <?php foreach($certificates as $c): ?>
                <div class="project-card" style="padding: 25px; text-align: center;">
                    <i class="fas fa-certificate" style="font-size: 40px; color: var(--accent); margin-bottom: 15px;"></i>
                    <h3 style="margin-top:0; font-size: 20px;"><?php echo htmlspecialchars($c['title'] ?? ''); ?></h3>
                    <p style="color: var(--accent); font-weight: bold; margin-bottom:5px; margin-top:5px;"><?php echo htmlspecialchars($c['issuer'] ?? ''); ?></p>
                    <p style="color: #94a3b8; font-size: 14px; margin-top:0;"><?php echo htmlspecialchars($c['issue_date'] ?? ''); ?></p>
                    <?php if(!empty($c['certificate_file'])): ?>
                        <a href="../assets/images/uploads/certificates/<?php echo htmlspecialchars($c['certificate_file']); ?>" target="_blank" style="display: inline-block; margin-top: 10px; padding: 8px 15px; background: var(--accent); color: var(--bg); text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 13px;">View Certificate</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <?php foreach($achievements as $a): ?>
                <div class="skill-badge" style="padding: 15px 25px; display: inline-block;">
                    <strong><?php echo htmlspecialchars($a['title'] ?? ''); ?></strong><br>
                    <span style="font-size: 12px; color: #94a3b8;"><?php echo htmlspecialchars($a['issuer'] ?? ''); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if(!empty($resume)): ?>
    <section style="text-align: center; margin: 60px 0;">
        <a href="../assets/images/uploads/resume/<?php echo htmlspecialchars($resume['file_path'] ?? ''); ?>" target="_blank" style="display: inline-block; padding: 15px 40px; background: var(--accent); color: var(--bg); text-decoration: none; border-radius: 30px; font-size: 18px; font-weight: bold; transition: transform 0.3s;"><i class="fas fa-file-pdf"></i> Download Full Resume</a>
    </section>
    <?php endif; ?>
    
<footer>
    <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($profile['full_name']); ?>. Created with Portfolio Builder.</p>
</footer>

</body>
</html>
