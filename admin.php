<?php 
require 'config.php'; 
if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit;
}

if($_POST['action']=='update'){
    $id = $_POST['id'];
    $status = $_POST['status'];
    $stmt = $pdo->prepare("UPDATE pendaftaran SET status=? WHERE id=?");
    $stmt->execute([$status,$id]);
}

$stmt = $pdo->query("SELECT * FROM pendaftaran ORDER BY created_at DESC LIMIT 50");
$pendaftar = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SMK TI</title>
    <style>
        body{background:#f8f9fa;font-family:Poppins,sans-serif}
        .admin-container{max-width:1400px;margin:0 auto;padding:20px}
        .header{display:flex;justify-content:space-between;align-items:center;background:white;padding:20px;border-radius:15px;margin-bottom:30px;box-shadow:0 10px 30px rgba(0,0,0,0.1)}
        .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;margin-bottom:30px}
        .stat-card{background:white;padding:30px;border-radius:15px;text-align:center;box-shadow:0 10px 30px rgba(0,0,0,0.1)}
        .stat-icon{font-size:3rem;margin-bottom:15px}
        .stat-card h3{font-size:2.5rem;color:#2563eb;margin-bottom:5px}
        .table-container{background:white;border-radius:15px;overflow:hidden;box-shadow:0 10px 30px rgba(0,0,0,0.1)}
        table{width:100%;border-collapse:collapse}
        th{padding:15px;background:#2563eb;color:white;text-align:left;font-weight:600}
        td{padding:15px;border-bottom:1px solid #eee}
        .status{display:inline-block;padding:5px 15px;border-radius:20px;font-size:14px;font-weight:600}
        .status-Menunggu{background:#fff3cd;color:#856404}
        .status-Diterima{background:#d4edda;color:#155724}
        .status-Ditolak{background:#f8d7da;color:#721c24}
        .btn{padding:8px 15px;border:none;border-radius:5px;cursor:pointer;font-weight:600;margin:2px;font-size:14px}
        .btn-success{background:#28a745;color:white}
        .btn-danger{background:#dc3545;color:white}
        .btn:hover{opacity:0.9}
        @media(max-width:768px){.header{flex-direction:column;text-align:center;gap:10px}}
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="header">
            <div>
                <h1>👨‍💼 Admin Dashboard</h1>
                <p>Selamat datang, <?= $_SESSION['username'] ?? 'Admin' ?></p>
            </div>
            <a href="logout.php" class="btn" style="background:#6c757d;color:white;padding:10px 20px">Logout</a>
        </div>

        <?php 
        $total = $pdo->query("SELECT COUNT(*) FROM pendaftaran")->fetchColumn();
        $diterima = $pdo->query("SELECT COUNT(*) FROM pendaftaran WHERE status='Diterima'")->fetchColumn();
        $menunggu = $pdo->query("SELECT COUNT(*) FROM pendaftaran WHERE status='Menunggu'")->fetchColumn();
        ?>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="color:#2563eb">📊</div>
                <h3><?= $total ?></h3>
                <p>Total Pendaftar</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="color:#28a745">✅</div>
                <h3><?= $diterima ?></h3>
                <p>Diterima</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="color:#ffc107">⏳</div>
                <h3><?= $menunggu ?></h3>
                <p>Menunggu</p>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>No Reg</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th>Telp</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($pendaftar as $row): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><strong><?= $row['no_reg'] ?></strong></td>
                        <td><?= $row['nisn'] ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['jurusan'] ?></td>
                        <td><?= $row['telp'] ?></td>
                        <td><span class="status status-<?= $row['status'] ?>"><?= $row['status'] ?></span></td>
                        <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                        <td>
                            <form method="POST" style="display:inline">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <input type="hidden" name="action" value="update">
                                <select name="status" onchange="this.form.submit()" style="padding:5px">
                                    <option value="Menunggu" <?= $row['status']=='Menunggu'?'selected':'' ?>>Menunggu</option>
                                    <option value="Diterima" <?= $row['status']=='Diterima'?'selected':'' ?>>Diterima</option>
                                    <option value="Ditolak" <?= $row['status']=='Ditolak'?'selected':'' ?>>Ditolak</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
