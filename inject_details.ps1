$html_block = <<<'EOD'
    <?php if(!empty($education)): ?>
    <section>
        <h2 class="section-title">My <span>Education</span></h2>
        <div class="projects-grid">
            <?php foreach($education as $e): ?>
                <div class="project-card" style="padding: 25px;">
                    <h3 style="margin-top:0; font-size: 20px;"><?php echo htmlspecialchars($e['degree']); ?></h3>
                    <p style="color: var(--accent); font-weight: bold; margin-bottom:5px; margin-top:5px;"><?php echo htmlspecialchars($e['institution']); ?></p>
                    <p style="color: #94a3b8; font-size: 14px; margin-top:0;"><?php echo htmlspecialchars($e['graduation_year']); ?></p>
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
                    <h3 style="margin-top:0; font-size: 20px;"><?php echo htmlspecialchars($i['role']); ?></h3>
                    <p style="color: var(--accent); font-weight: bold; margin-bottom:5px; margin-top:5px;"><?php echo htmlspecialchars($i['company']); ?></p>
                    <p style="color: #94a3b8; font-size: 14px; margin-top:0;"><?php echo htmlspecialchars($i['start_date']) . ' to ' . htmlspecialchars($i['end_date']); ?></p>
                    <p style="font-size: 14px;"><?php echo htmlspecialchars($i['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if(!empty($hackathons)): ?>
    <section>
        <h2 class="section-title"><span>Hackathons</span></h2>
        <div class="projects-grid">
            <?php foreach($hackathons as $h): ?>
                <div class="project-card" style="padding: 25px;">
                    <h3 style="margin-top:0; font-size: 20px;"><?php echo htmlspecialchars($h['hackathon_name']); ?></h3>
                    <p style="color: var(--accent); font-weight: bold; margin-bottom:5px; margin-top:5px;"><?php echo htmlspecialchars($h['project_title']); ?></p>
                    <p style="color: #94a3b8; font-size: 14px; margin-top:0;"><?php echo htmlspecialchars($h['date']); ?></p>
                    <p style="font-size: 14px;"><?php echo htmlspecialchars($h['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if(!empty($certificates)): ?>
    <section>
        <h2 class="section-title"><span>Certificates</span></h2>
        <div class="projects-grid">
            <?php foreach($certificates as $c): ?>
                <div class="project-card" style="padding: 25px;">
                    <h3 style="margin-top:0; font-size: 20px;"><?php echo htmlspecialchars($c['title']); ?></h3>
                    <p style="color: var(--accent); font-weight: bold; margin-bottom:5px; margin-top:5px;"><?php echo htmlspecialchars($c['issuer']); ?></p>
                    <p style="color: #94a3b8; font-size: 14px; margin-top:0;"><?php echo htmlspecialchars($c['issue_date']); ?></p>
                    <?php if($c['certificate_file']): ?>
                        <a href="../assets/images/uploads/certificates/<?php echo htmlspecialchars($c['certificate_file']); ?>" target="_blank" style="display: inline-block; margin-top: 10px; padding: 8px 15px; background: var(--accent); color: var(--bg); text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 13px;">View Certificate</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if(!empty($achievements)): ?>
    <section>
        <h2 class="section-title"><span>Achievements</span></h2>
        <div class="skills-grid">
            <?php foreach($achievements as $a): ?>
                <div class="skill-badge" style="padding: 15px 25px; display: inline-block;">
                    <strong><?php echo htmlspecialchars($a['title']); ?></strong><br>
                    <span style="font-size: 12px; color: #94a3b8;"><?php echo htmlspecialchars($a['issuer']); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if(!empty($resume)): ?>
    <section style="text-align: center; margin: 60px 0;">
        <a href="../assets/images/uploads/resume/<?php echo htmlspecialchars($resume['file_path']); ?>" target="_blank" style="display: inline-block; padding: 15px 40px; background: var(--accent); color: var(--bg); text-decoration: none; border-radius: 30px; font-size: 18px; font-weight: bold; transition: transform 0.3s;"><i class="fas fa-file-pdf"></i> Download Full Resume</a>
    </section>
    <?php endif; ?>

EOD;

foreach (Get-ChildItem -Path "c:\xampp\htdocs\Portfolio_Builder\templates" -Filter "template*.php") {
    $content = Get-Content $_.FullName -Raw
    if ($content -notmatch "My <span>Education</span>") {
        $content = $content -replace '<footer>', "$html_block
    <footer>"
        Set-Content -Path $_.FullName -Value $content
    }
}
