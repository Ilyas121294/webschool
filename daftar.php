<?php require 'config.php'; 
if($_POST){
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $telp = $_POST['telp'];
    
    $no_reg = 'SMKTI-' . date('Y') . '-' . str_pad($pdo->lastInsertId()+1, 4, '0', STR_PAD_LEFT);
    
    $stmt = $pdo->prepare("INSERT INTO pendaftaran (no_reg, nisn, nama, jurusan, telp, data) VALUES (?, ?, ?, ?, ?, ?)");
    $data = json_encode($_POST);
    $stmt->execute([$no_reg, $nisn, $nama, $jurusan, $telp, $data]);
    
    $id = $pdo->lastInsertId();
    echo "<script>alert('Berhasil! No Registrasi: $no_reg'); window.location='daftar.php?success=1&id=$id';</script>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran - SMK TI</title>
    <style>
        body{background:#f8f9fa; padding:20px; font-family:Poppins,sans-serif}
        .form-container{max-width:600px;margin:0 auto;background:white;padding:40px;border-radius:20px;box-shadow:0 20px 60px rgba(0,0,0,0.1)}
        .form-group{margin-bottom:20px}
        label{display:block;margin-bottom:8px;font-weight:600;color:#333}
        input,select{padding:12px;border:2px solid #e2e8f0;border-radius:10px;font-size:16px;width:100%;transition:border-color 0.3s}
        input:focus,select:focus{outline:none;border-color:#2563eb}
        .btn{padding:15px 30px;background:#2563eb;color:white;border:none;border-radius:10px;cursor:pointer;font-size:16px;font-weight:600;width:100%;transition:all 0.3s}
        .btn:hover{background:#1d4ed8;transform:translateY(-2px)}
        .success{background:#d4edda;color:#155724;padding:20px;border-radius:10px;margin-bottom:20px;border:1px solid #c3e6cb}
        h1{text-align:center;color:#2563eb;margin-bottom:10px}
        .subtitle{text-align:center;color:#666;margin-bottom:40px}
    </style>
</head>
<body>
    <div class="form-container">
        <h1>📝 Pendaftaran Siswa Baru</h1>
        <p class="subtitle">Isi data dengan lengkap dan benar</p>
        
        <?php if(isset($_GET['success'])): 
            $stmt = $pdo->prepare("SELECT * FROM pendaftaran WHERE id=?");
            $stmt->execute([$_GET['id']]);
            $data = $stmt->fetch();
        ?>
        <div class="success">
            ✅ <strong>Berhasil!</strong> No Registrasi: <strong><?= $data['no_reg'] ?></strong><br>
            Simpan nomor ini untuk tracking status
        </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>NISN <span style="color:red">*</span></label>
                <input type="text" name="nisn" required maxlength="10">
            </div>
            <div class="form-group">
                <label>Nama Lengkap <span style="color:red">*</span></label>
                <input type="text" name="nama" required>
            </div>
            <div class="form-group">
                <label>Jurusan <span style="color:red">*</span></label>
                <select name="jurusan" required>
                    <option value="">Pilih Jurusan</option>
                    <option value="RPL">RPL (Rekayasa Perangkat Lunak)</option>
                    <option value="TKJ">TKJ (Teknik Komputer & Jaringan)</option>
                    <option value="DGM">DGM (Desain Grafis & Multimedia)</option>
                </select>
            </div>
            <div class="form-group">
                <label>No. WhatsApp <span style="color:red">*</span></label>
                <input type="tel" name="telp" required placeholder="08xxxxxxxxx">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" rows="3" style="resize:vertical"></textarea>
            </div>
            <button type="submit" class="btn">🚀 Daftar Sekarang</button>
        </form>
        
        <div style="text-align:center;margin-top:30px;padding-top:20px;border-top:1px solid #eee">
            <a href="index.php" style="color:#666;text-decoration:none">← Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
