<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($profile['full_name']); ?> - Minimal Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root { --text: #6c71c4; --bg: #fdf6e3; --gray: #2aa198; --border: #eee; }
        body { font-family: 'Space Grotesk', sans-serif; margin: 0; padding: 0; background: var(--bg); color: var(--text); }
        .container { max-width: 800px; margin: 0 auto; padding: 100px 20px; }
        
        .header { margin-bottom: 80px; }
        .header h1 { font-size: 48px; font-weight: 600; margin: 0 0 10px 0; letter-spacing: -1px; }
        .header h2 { font-size: 20px; font-weight: 400; color: var(--gray); margin: 0 0 30px 0; }
        .header p { font-size: 16px; line-height: 1.6; max-width: 600px; }
        
        .section-title { font-size: 14px; text-transform: uppercase; letter-spacing: 2px; color: var(--gray); border-bottom: 1px solid var(--border); padding-bottom: 10px; margin-bottom: 30px; margin-top: 80px; }
        
        .project-item { margin-bottom: 40px; }
        .project-item h3 { font-size: 20px; margin: 0 0 5px 0; }
        .project-item span { font-size: 14px; color: var(--gray); }
        .project-item p { margin: 15px 0 0 0; line-height: 1.6; }
        
        .skills-list { display: flex; flex-wrap: wrap; gap: 10px; list-style: none; padding: 0; }
        .skills-list li { padding: 5px 15px; border: 1px solid var(--border); border-radius: 4px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><?php echo htmlspecialchars($profile['full_name']); ?></h1>
            <h2><?php echo htmlspecialchars($profile['headline'] ?? ''); ?></h2>
            <p><?php echo htmlspecialchars($profile['about'] ?? ''); ?></p>
        </div>

        <?php if(!empty($projects)): ?>
        <div class="section-title">Projects</div>
        <div>
            <?php foreach($projects as $p): ?>
                <div class="project-item">
                    <h3><?php echo htmlspecialchars($p['title']); ?></h3>
                    <span><?php echo htmlspecialchars($p['technologies']); ?></span>
                    <p><?php echo htmlspecialchars($p['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if(!empty($skills)): ?>
        <div class="section-title">Skills</div>
        <ul class="skills-list">
            <?php foreach($skills as $s): ?>
                <li><?php echo htmlspecialchars($s['skill_name']); ?></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
</body>
</html>

