<?php 
require 'config.php'; 
if(isset($_SESSION['user_id'])) header('Location: admin.php');

if($_POST){
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if($user && password_verify($password, $user['password'])){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: admin.php');
        exit;
    } else {
        $error = "Username/password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <style>
        body{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);height:100vh;display:flex;align-items:center;justify-content:center;font-family:Poppins,sans-serif}
        .login-box{background:white;padding:50px;border-radius:20px;box-shadow:0 20px 60px rgba(0,0,0,0.3);width:100%;max-width:400px}
        .logo{text-align:center;margin-bottom:30px}
        .logo i{font-size:4rem;color:#2563eb}
        h2{text-align:center;color:#333;margin-bottom:30px}
        .form-group{margin-bottom:25px}
        label{display:block;margin-bottom:8px;color:#555;font-weight:500}
        input{padding:15px;border:2px solid #e2e8f0;border-radius:10px;width:100%;font-size:16px;transition:all 0.3s}
        input:focus{outline:none;border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,0.1)}
        .btn{width:100%;padding:15px;background:#2563eb;color:white;border:none;border-radius:10px;font-size:16px;font-weight:600;cursor:pointer;transition:all 0.3s}
        .btn:hover{background:#1d4ed8;transform:translateY(-2px)}
        .error{background:#f8d7da;color:#721c24;padding:15px;border-radius:10px;margin-bottom:20px;border:1px solid #f5c6cb}
        .info{background:#d1ecf1;color:#0c5460;padding:15px;border-radius:10px;margin-top:20px;border:1px solid #bee5eb}
    </style>
</head>
<body>
    <div class="login-box">
        <div class="logo">
            <i class="fas fa-lock"></i>
        </div>
        <h2>🔐 Admin Login</h2>
        
        <?php if(isset($error)): ?>
        <div class="error"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required value="admin">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        
        <div class="info">
            <strong>Default Login:</strong><br>
            Username: <code>admin</code><br>
            Password: <code>admin</code>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
