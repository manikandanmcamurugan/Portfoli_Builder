<?php
require_once 'includes/auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Builder - Create Your Professional Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Modern reset and base styles */
        body { font-family: 'Inter', sans-serif; margin: 0; padding: 0; color: #333; line-height: 1.6; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        
        /* Navbar */
        header { background: #fff; padding: 20px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 100; }
        .navbar { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 24px; font-weight: 700; color: #0066ff; text-decoration: none; }
        .nav-links a { text-decoration: none; color: #555; margin-left: 30px; font-weight: 500; transition: color 0.3s; }
        .nav-links a:hover { color: #0066ff; }
        .btn-login { background: transparent; border: 2px solid #0066ff; color: #0066ff !important; padding: 8px 20px; border-radius: 6px; }
        .btn-login:hover { background: #0066ff; color: #fff !important; }
        .btn-register { background: #0066ff; color: #fff !important; padding: 10px 24px; border-radius: 6px; margin-left: 15px; }
        .btn-register:hover { background: #0052cc; }

        /* Hero Section */
        .hero { padding: 100px 0; text-align: center; background: linear-gradient(135deg, #f4f7f6 0%, #e0eafc 100%); }
        .hero h1 { font-size: 56px; font-weight: 700; color: #1a1a1a; margin-bottom: 20px; line-height: 1.2; }
        .hero p { font-size: 20px; color: #555; max-width: 700px; margin: 0 auto 40px; }
        .hero .btn-main { background: #0066ff; color: white; padding: 16px 40px; font-size: 18px; font-weight: 600; text-decoration: none; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,102,255,0.3); transition: transform 0.3s, box-shadow 0.3s; display: inline-block; }
        .hero .btn-main:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,102,255,0.4); }

        /* Features Section */
        .features { padding: 80px 0; background: #fff; }
        .section-title { text-align: center; font-size: 36px; font-weight: 700; margin-bottom: 60px; }
        .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; }
        .feature-card { background: #f9fbff; padding: 40px; border-radius: 12px; text-align: center; border: 1px solid #eef2f9; transition: transform 0.3s; }
        .feature-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .feature-card h3 { font-size: 22px; color: #333; margin-bottom: 15px; }
        .feature-card p { color: #666; font-size: 15px; }
        .icon { font-size: 40px; margin-bottom: 20px; }

        /* Footer */
        footer { background: #1a1a1a; color: #fff; padding: 40px 0; text-align: center; }
        footer p { margin: 0; color: #aaa; }
    </style>
</head>
<body>

    <header>
        <div class="container navbar">
            <a href="index.php" class="logo">PortfolioBuilder</a>
            <div class="nav-links">
                <?php if (isLoggedIn()): ?>
                    <a href="dashboard/index.php" class="btn-register">Go to Dashboard</a>
                <?php else: ?>
                    <a href="login.php" class="btn-login">Login</a>
                    <a href="register.php" class="btn-register">Create Portfolio</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <h1>Build Your Professional Portfolio</h1>
            <p>Create, customize and share your professional portfolio in minutes. Choose from stunning templates and stand out to recruiters.</p>
            <a href="register.php" class="btn-main">Create Portfolio</a>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <h2 class="section-title">Why Use Our Portfolio Builder?</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="icon">🚀</div>
                    <h3>Fast & Easy</h3>
                    <p>No coding required. Just fill in your details and generate a beautiful portfolio instantly.</p>
                </div>
                <div class="feature-card">
                    <div class="icon">🎨</div>
                    <h3>Multiple Templates</h3>
                    <p>Choose from Modern, Professional, Creative, Minimal, and Developer templates.</p>
                </div>
                <div class="feature-card">
                    <div class="icon">📱</div>
                    <h3>Fully Responsive</h3>
                    <p>Your portfolio will look perfect on desktops, tablets, and mobile devices.</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Portfolio Builder. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
