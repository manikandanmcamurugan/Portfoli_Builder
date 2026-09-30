Add-Type -AssemblyName System.Drawing

$templates = @(
    @{slug='crimson-code'; name='Crimson Code'; bg='#000000'; fg='#dc143c'},
    @{slug='aqua-marine'; name='Aqua Marine'; bg='#ffffff'; fg='#20b2aa'},
    @{slug='purple-rain'; name='Purple Rain'; bg='#1e1025'; fg='#9370db'},
    @{slug='solar-flare'; name='Solar Flare'; bg='#fffdf0'; fg='#ff8c00'},
    @{slug='midnight-blue'; name='Midnight Blue'; bg='#0a192f'; fg='#64ffda'},
    @{slug='cherry-blossom'; name='Cherry Blossom'; bg='#fff0f5'; fg='#ffb7c5'},
    @{slug='slate-grey'; name='Slate Grey'; bg='#2f4f4f'; fg='#778899'},
    @{slug='golden-hour'; name='Golden Hour'; bg='#fafad2'; fg='#daa520'},
    @{slug='emerald-city'; name='Emerald City'; bg='#002910'; fg='#50c878'},
    @{slug='ice-cold'; name='Ice Cold'; bg='#f0ffff'; fg='#add8e6'},
    @{slug='neon-pink'; name='Neon Pink'; bg='#0d0d0d'; fg='#ff1493'},
    @{slug='classic-red'; name='Classic Red'; bg='#ffffff'; fg='#b22222'},
    @{slug='space-nebula'; name='Space Nebula'; bg='#0f0518'; fg='#ba55d3'},
    @{slug='minty-fresh'; name='Minty Fresh'; bg='#f5fffa'; fg='#00ff7f'},
    @{slug='graphite'; name='Graphite'; bg='#1c1c1c'; fg='#9e9e9e'},
    @{slug='peach-perfect'; name='Peach Perfect'; bg='#fff5ee'; fg='#ffdab9'},
    @{slug='deep-ocean'; name='Deep Ocean'; bg='#00008b'; fg='#4169e1'},
    @{slug='citrus-splash'; name='Citrus Splash'; bg='#ffffff'; fg='#ff8c00'},
    @{slug='ruby-red'; name='Ruby Red'; bg='#1a0000'; fg='#e0115f'},
    @{slug='lavender-dream'; name='Lavender Dream'; bg='#f8f8ff'; fg='#e6e6fa'},
    @{slug='cyber-yellow'; name='Cyber Yellow'; bg='#000000'; fg='#ffd700'},
    @{slug='coral-reef'; name='Coral Reef'; bg='#ffffff'; fg='#ff7f50'},
    @{slug='olive-branch'; name='Olive Branch'; bg='#191c13'; fg='#6b8e23'},
    @{slug='cotton-candy'; name='Cotton Candy'; bg='#ffffff'; fg='#ffb6c1'},
    @{slug='dark-chocolate'; name='Dark Chocolate'; bg='#2b1b17'; fg='#d2691e'},
    @{slug='sky-high'; name='Sky High'; bg='#ffffff'; fg='#87ceeb'},
    @{slug='amethyst'; name='Amethyst'; bg='#1a1124'; fg='#9966cc'},
    @{slug='matcha-green'; name='Matcha Green'; bg='#fdf5e6'; fg='#90ee90'},
    @{slug='volcano'; name='Volcano'; bg='#212121'; fg='#ff4500'},
    @{slug='pure-white'; name='Pure White'; bg='#ffffff'; fg='#000000'}
)

foreach ($t in $templates) {
    $bmp = New-Object System.Drawing.Bitmap(400, 300)
    $g = [System.Drawing.Graphics]::FromImage($bmp)
    
    $bgColor = [System.Drawing.ColorTranslator]::FromHtml($t.bg)
    $fgColor = [System.Drawing.ColorTranslator]::FromHtml($t.fg)
    
    $g.Clear($bgColor)
    
    $font = New-Object System.Drawing.Font("Arial", 24)
    $brush = New-Object System.Drawing.SolidBrush($fgColor)
    
    $format = New-Object System.Drawing.StringFormat
    $format.Alignment = [System.Drawing.StringAlignment]::Center
    $format.LineAlignment = [System.Drawing.StringAlignment]::Center
    
    $rect = New-Object System.Drawing.RectangleF(0, 0, 400, 300)
    $g.DrawString($t.name, $font, $brush, $rect, $format)
    
    $slug = $t.slug
    $dest1 = "C:\xampp\htdocs\Portfolio_Builder\assets\images\uploads\templates\$slug.png"
    $dest2 = "C:\xampp\htdocs\Portfolio_Builder\assets\images\templates\$slug.png"
    
    $bmp.Save($dest1, [System.Drawing.Imaging.ImageFormat]::Png)
    $bmp.Save($dest2, [System.Drawing.Imaging.ImageFormat]::Png)
    
    $g.Dispose()
    $bmp.Dispose()
}
