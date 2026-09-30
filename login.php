<?php
require_once 'includes/auth.php';
require_once 'config/database.php';

if (isLoggedIn()) {
    if (getUserRole() === 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: dashboard/index.php");
    }
    exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Both fields are required.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            if ($user['status'] === 'inactive') {
                $error = "Your account is inactive. Please contact support.";
            } else {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['logged_in'] = true;
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];
                
                if ($user['role'] === 'admin') {
                    header("Location: admin/dashboard.php");
                } else {
                    header("Location: dashboard/index.php");
                }
                exit;
            }
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Portfolio Builder</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Outfit', sans-serif; margin: 0; padding: 0; display: flex; min-height: 100vh; background-color: #f8fafc; }
        .split-layout { display: flex; width: 100%; }
        
        /* Left Side Panel */
        .hero-side { flex: 1; background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); color: white; display: flex; flex-direction: column; justify-content: center; padding: 60px; position: relative; overflow: hidden; }
        .hero-side::before { content: ''; position: absolute; width: 600px; height: 600px; background: radial-gradient(circle, rgba(99,102,241,0.2) 0%, rgba(0,0,0,0) 70%); top: -100px; left: -100px; border-radius: 50%; }
        .hero-side::after { content: ''; position: absolute; width: 400px; height: 400px; background: radial-gradient(circle, rgba(236,72,153,0.15) 0%, rgba(0,0,0,0) 70%); bottom: -50px; right: -50px; border-radius: 50%; }
        .hero-content { position: relative; z-index: 1; max-width: 500px; }
        .hero-content h1 { font-size: 3.5rem; font-weight: 700; line-height: 1.1; margin-bottom: 20px; }
        .hero-content p { font-size: 1.1rem; color: #94a3b8; line-height: 1.6; }
        .brand { position: absolute; top: 40px; left: 60px; font-size: 1.5rem; font-weight: 700; display: flex; align-items: center; gap: 10px; z-index: 2; color: #fff; text-decoration: none; }
        
        /* Right Side Panel */
        .form-side { flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px; background: #fff; }
        .auth-container { width: 100%; max-width: 420px; }
        .auth-container h2 { font-size: 2rem; color: #0f172a; margin-bottom: 10px; font-weight: 600; }
        .auth-container > p { color: #64748b; margin-bottom: 30px; }
        
        .form-group { margin-bottom: 20px; position: relative; }
        .form-group label { display: block; margin-bottom: 8px; color: #334155; font-size: 0.9rem; font-weight: 500; }
        .form-control { width: 100%; padding: 14px 16px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; font-family: 'Outfit', sans-serif; background: #f8fafc; }
        .form-control:focus { border-color: #6366f1; background: #fff; outline: none; box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); }
        
        .btn-primary { width: 100%; padding: 14px; background: #6366f1; color: white; border: none; border-radius: 10px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; margin-top: 10px; }
        .btn-primary:hover { background: #4f46e5; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3); }
        
        .error { background: #fef2f2; border: 1px solid #fecaca; color: #ef4444; padding: 12px 16px; border-radius: 8px; font-size: 0.9rem; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .auth-links { text-align: center; margin-top: 30px; font-size: 0.95rem; color: #64748b; }
        .auth-links a { color: #6366f1; text-decoration: none; font-weight: 600; transition: color 0.3s; }
        .auth-links a:hover { color: #4f46e5; }
        
        @media (max-width: 900px) {
            .hero-side { display: none; }
            .form-side { background: #f8fafc; }
            .auth-container { background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); }
        }
    </style>
</head>
<body>
    <div class="split-layout">
        <div class="hero-side">
            <a href="index.php" class="brand"><i class="fas fa-layer-group"></i> Portfolio Builder</a>
            <div class="hero-content">
                <h1>Craft your perfect portfolio.</h1>
                <p>Sign in to access your dashboard, customize your template, and publish your professional journey to the world in just a few clicks.</p>
            </div>
        </div>
        
        <div class="form-side">
            <div class="auth-container">
                <h2>Welcome back</h2>
                <p>Please enter your details to sign in.</p>
                
                <?php if ($error) echo "<div class='error'><i class='fas fa-exclamation-circle'></i> $error</div>"; ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn-primary">Sign In</button>
                </form>
                
                <div class="auth-links">
                    Don't have an account? <a href="register.php">Create an account</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


