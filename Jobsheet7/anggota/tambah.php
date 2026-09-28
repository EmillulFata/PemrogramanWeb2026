<?php
$page_title = 'Tambah Anggota';
require_once __DIR__ . '/../includes/header.php';
?>

<h2>Tambah Anggota Baru</h2>

<?php if (isset($_SESSION['flash'])): ?>
    <div class="alert alert-<?php echo $_SESSION['flash']['type']; ?>">
        <?php 
            echo htmlspecialchars($_SESSION['flash']['pesan']); 
            unset($_SESSION['flash']);
        ?>
    </div>
<?php endif; ?>

<form action="proses_tambah.php" method="POST" class="form-group">
    <div class="form-control">
        <label for="no_anggota">Nomor Anggota <span class="required">*</span></label>
        <input type="text" id="no_anggota" name="no_anggota" placeholder="Contoh: ANG-2026001" required>
    </div>

    <div class="form-control">
        <label for="nama">Nama Lengkap <span class="required">*</span></label>
        <input type="text" id="nama" name="nama" required>
    </div>

    <div class="form-control">
        <label for="email">Email <span class="required">*</span></label>
        <input type="email" id="email" name="email" required>
    </div>

    <div class="form-control">
        <label for="telepon">Nomor Telepon</label>
        <input type="text" id="telepon" name="telepon" placeholder="Contoh: 081234567890">
    </div>

    <div class="form-control">
        <label for="alamat">Alamat</label>
        <textarea id="alamat" name="alamat" rows="3"></textarea>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Simpan Anggota</button>
        <a href="list.php" class="btn btn-secondary">Batal</a>
    </div>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>