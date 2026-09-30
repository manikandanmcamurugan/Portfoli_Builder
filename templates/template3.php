<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($profile['full_name']); ?> - Creative Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary: #ff3366; --secondary: #7c4dff; --bg: #fff; --text: #222; }
        body { font-family: 'Outfit', sans-serif; margin: 0; background: var(--bg); color: var(--text); overflow-x: hidden; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 5%; }
        
        .hero { min-height: 100vh; display: flex; align-items: center; position: relative; }
        .hero-bg { position: absolute; top: -10%; right: -10%; width: 50%; height: 80%; background: linear-gradient(45deg, var(--primary), var(--secondary)); border-radius: 50%; filter: blur(100px); opacity: 0.2; z-index: -1; }
        
        .hero-content { display: flex; align-items: center; justify-content: space-between; width: 100%; }
        .hero-text { flex: 1; padding-right: 50px; }
        .hero-text h1 { font-size: 80px; font-weight: 800; line-height: 1; margin: 0 0 20px 0; background: linear-gradient(45deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero-text h2 { font-size: 30px; font-weight: 500; margin: 0 0 30px 0; }
        .hero-text p { font-size: 18px; color: #555; max-width: 500px; line-height: 1.6; margin-bottom: 40px; }
        
        .hero-img { flex: 1; display: flex; justify-content: flex-end; }
        .hero-img img { max-width: 400px; border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; box-shadow: 20px 20px 60px rgba(0,0,0,0.1); animation: morph 8s ease-in-out infinite; }
        
        @keyframes morph { 0% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; } 50% { border-radius: 70% 30% 30% 70% / 70% 70% 30% 30%; } 100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; } }
        
        .section { padding: 100px 0; }
        .section-title { font-size: 50px; font-weight: 800; margin-bottom: 60px; text-align: center; }
        
        .project-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; }
        .project-card { position: relative; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1); cursor: pointer; }
        .project-card img { width: 100%; height: 300px; object-fit: cover; transition: transform 0.5s; }
        .project-card:hover img { transform: scale(1.1); }
        .project-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); display: flex; flex-direction: column; justify-content: flex-end; padding: 30px; opacity: 0; transition: opacity 0.3s; color: #fff; }
        .project-card:hover .project-overlay { opacity: 1; }
        
        .skills-container { display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; }
        .skill-bubble { background: linear-gradient(45deg, var(--primary), var(--secondary)); color: #fff; padding: 15px 30px; border-radius: 50px; font-size: 18px; font-weight: 500; box-shadow: 0 10px 20px rgba(255,51,102,0.3); }
        
        @media (max-width: 768px) {
            .hero-content { flex-direction: column; text-align: center; }
            .hero-text { padding: 0; margin-bottom: 50px; }
            .hero-text h1 { font-size: 50px; }
            .hero-img { justify-content: center; }
        }
    </style>
</head>
<body>
    <div class="hero-bg"></div>
    <div class="container">
        <div class="hero">
            <div class="hero-content">
                <div class="hero-text">
                    <h2>Hello, I am</h2>
                    <h1><?php echo htmlspecialchars($profile['full_name']); ?></h1>
                    <h2><?php echo htmlspecialchars($profile['headline'] ?? ''); ?></h2>
                    <p><?php echo htmlspecialchars($profile['about'] ?? ''); ?></p>
                </div>
                <div class="hero-img">
                    <?php if(!empty($profile['profile_photo'])): ?>
                        <img src="../assets/images/uploads/profile/<?php echo htmlspecialchars($profile['profile_photo']); ?>" alt="Profile">
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <?php if(!empty($skills)): ?>
        <div class="section">
            <h2 class="section-title">My Toolkit</h2>
            <div class="skills-container">
                <?php foreach($skills as $s): ?>
                    <div class="skill-bubble"><?php echo htmlspecialchars($s['skill_name']); ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if(!empty($projects)): ?>
        <div class="section">
            <h2 class="section-title">Creative Works</h2>
            <div class="project-grid">
                <?php foreach($projects as $p): ?>
                    <div class="project-card">
                        <?php if($p['image']): ?>
                            <img src="../assets/images/uploads/projects/<?php echo htmlspecialchars($p['image']); ?>">
                        <?php else: ?>
                            <div style="width:100%; height:300px; background:#eee;"></div>
                        <?php endif; ?>
                        <div class="project-overlay">
                            <h3><?php echo htmlspecialchars($p['title']); ?></h3>
                            <p><?php echo htmlspecialchars($p['technologies']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
