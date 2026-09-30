<?php
session_start();
require_once 'config/database.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Email already registered.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'student')");
            if ($stmt->execute([$name, $email, $hashed_password])) {
                $user_id = $pdo->lastInsertId();
                $stmt_profile = $pdo->prepare("INSERT INTO profiles (user_id, full_name) VALUES (?, ?)");
                $stmt_profile->execute([$user_id, $name]);
                
                session_start();
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user_id;
                $_SESSION['name'] = $name;
                $_SESSION['role'] = 'student';
                $_SESSION['logged_in'] = true;
                header("Location: dashboard/index.php");
                exit;
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Portfolio Builder</title>
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
        .success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; padding: 16px; border-radius: 8px; font-size: 1rem; margin-bottom: 20px; text-align: center; display: flex; flex-direction: column; gap: 15px; }
        
        .auth-links { text-align: center; margin-top: 30px; font-size: 0.95rem; color: #64748b; }
        .auth-links a { color: #6366f1; text-decoration: none; font-weight: 600; transition: color 0.3s; }
        .auth-links a:hover { color: #4f46e5; }
        
        .row { display: flex; gap: 15px; }
        .col { flex: 1; }
        
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
                <h1>Start your journey.</h1>
                <p>Join thousands of professionals building beautiful, responsive portfolios that stand out to recruiters and clients.</p>
            </div>
        </div>
        
        <div class="form-side">
            <div class="auth-container">
                <h2>Create Account</h2>
                <p>Enter your details below to get started.</p>
                
                <?php if ($error) echo "<div class='error'><i class='fas fa-exclamation-circle'></i> $error</div>"; ?>
                
                <?php if ($success) { 
                    echo "<div class='success'><i class='fas fa-check-circle' style='font-size: 2rem;'></i> $success <a href='login.php' class='btn-primary' style='display:inline-block; text-decoration:none; margin-top:10px;'>Go to Login</a></div>";
                } else { ?>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Full Name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="Email Address" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                        </div>
                        <div class="row">
                            <div class="col form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required minlength="8">
                            </div>
                            <div class="col form-group">
                                <label>Confirm</label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Repeat Password" required minlength="8">
                            </div>
                        </div>
                        <button type="submit" class="btn-primary">Create Account</button>
                    </form>
                    
                    <div class="auth-links">
                        Already have an account? <a href="login.php">Sign in instead</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>


