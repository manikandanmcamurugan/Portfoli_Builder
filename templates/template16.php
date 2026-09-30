<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($profile['full_name']); ?> - Dev Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root { --bg: #000; --text: #0f0; --accent: #0f0; --comment: #8b949e; --border: #30363d; --card: #161b22; }
        body { font-family: 'Fira Code', monospace; background: var(--bg); color: var(--text); margin: 0; padding: 40px 20px; line-height: 1.6; }
        .terminal { max-width: 900px; margin: 0 auto; background: var(--card); border: 1px solid var(--border); border-radius: 6px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        .header { margin-bottom: 40px; }
        .prompt::before { content: "$ "; color: #3fb950; font-weight: bold; }
        .command { color: var(--accent); font-weight: bold; }
        .output { margin-top: 10px; color: var(--text); white-space: pre-wrap; }
        h1 { font-size: 24px; color: #ff7b72; margin: 10px 0; }
        .comment { color: var(--comment); }
        .keyword { color: #ff7b72; }
        .string { color: #a5d6ff; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 20px; }
        .box { border: 1px solid var(--border); padding: 15px; border-radius: 4px; }
        .box h3 { color: var(--accent); margin: 0 0 10px 0; font-size: 16px; }
    </style>
</head>
<body>
    <div class="terminal">
        <div class="header">
            <span class="prompt"></span><span class="command">whoami</span>
            <div class="output">
                <h1><?php echo htmlspecialchars($profile['full_name']); ?></h1>
                <p class="comment">// <?php echo htmlspecialchars($profile['headline'] ?? ''); ?></p>
                <p><?php echo htmlspecialchars($profile['about'] ?? ''); ?></p>
            </div>
        </div>

        <?php if(!empty($skills)): ?>
        <div class="section">
            <span class="prompt"></span><span class="command">cat skills.json</span>
            <div class="output">
                {
                <div style="padding-left: 20px;">
                    <?php foreach($skills as $s): ?>
                        <span class="string">"<?php echo htmlspecialchars($s['skill_name']); ?>"</span>: <span class="keyword">"<?php echo htmlspecialchars($s['skill_level']); ?>"</span>,
                        <br>
                    <?php endforeach; ?>
                </div>
                }
            </div>
        </div>
        <br><br>
        <?php endif; ?>

        <?php if(!empty($projects)): ?>
        <div class="section">
            <span class="prompt"></span><span class="command">ls -l ./projects</span>
            <div class="output grid">
                <?php foreach($projects as $p): ?>
                    <div class="box">
                        <h3>./<?php echo strtolower(str_replace(' ', '_', htmlspecialchars($p['title']))); ?></h3>
                        <p class="comment">// Tech: <?php echo htmlspecialchars($p['technologies']); ?></p>
                        <p><?php echo htmlspecialchars($p['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>

