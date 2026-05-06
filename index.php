<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMK TI - Pendaftaran Online</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:Poppins,sans-serif}
        body{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);min-height:100vh;display:flex;align-items:center;justify-content:center}
        .container{max-width:1200px;margin:0 auto;padding:20px;width:100%}
        .header{text-align:center;color:white;margin-bottom:40px}
        .quick-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:20px;margin-bottom:40px}
        .card{background:white;padding:30px;border-radius:20px;box-shadow:0 20px 60px rgba(0,0,0,0.1);text-align:center;transition:transform 0.3s}
        .card:hover{transform:translateY(-10px)}
        .card i{font-size:3rem;color:#2563eb;margin-bottom:20px}
        .card h3{color:#333;font-size:1.5rem;margin-bottom:10px}
        .btn{display:inline-block;padding:15px 30px;background:#2563eb;color:white;text-decoration:none;border-radius:50px;font-weight:600;transition:all 0.3s}
        .btn:hover{background:#1d4ed8;transform:translateY(-2px)}
        .stats{display:flex;justify-content:center;gap:40px;flex-wrap:wrap}
        .stat{background:white;padding:30px;border-radius:20px;text-align:center;box-shadow:0 10px 40px rgba(0,0,0,0.1);min-width:200px}
        .stat h3{font-size:2.5rem;color:#2563eb}
        @media(max-width:768px){.stats{flex-direction:column;align-items:center}}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏫 SMK TEKNOLOGI INFORMATIKA</h1>
            <p>Sistem Pendaftaran Online & Manajemen Sekolah</p>
        </div>

        <div class="quick-grid">
            <a href="daftar.php" class="card">
                <i class="fas fa-user-plus"></i>
                <h3>Pendaftaran Online</h3>
                <p>Daftar siswa baru 24/7</p>
            </a>
            <a href="admin.php" class="card">
                <i class="fas fa-tachometer-alt"></i>
                <h3>Admin Panel</h3>
                <p>Kelola data siswa</p>
            </a>
            <a href="#stats" class="card">
                <i class="fas fa-chart-bar"></i>
                <h3>Statistik</h3>
                <p>Data real-time</p>
            </a>
        </div>

        <div class="stats" id="stats">
            <?php
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM pendaftaran");
            $total = $stmt->fetch()['total'];
            $stmt = $pdo->query("SELECT COUNT(*) as diterima FROM pendaftaran WHERE status='Diterima'");
            $diterima = $stmt->fetch()['diterima'];
            ?>
            <div class="stat">
                <h3><?= $total ?></h3>
                <p>Total Pendaftar</p>
            </div>
            <div class="stat">
                <h3><?= $diterima ?></h3>
                <p>Diterima</p>
            </div>
            <div class="stat">
                <h3><?= $total - $diterima ?></h3>
                <p>Menunggu</p>
            </div>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
