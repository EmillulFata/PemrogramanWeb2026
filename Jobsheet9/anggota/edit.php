<?php
$page_title = 'Edit Anggota';
$base = '../';
require_once __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'ID anggota tidak valid!'];
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM anggota WHERE id = :id");
$stmt->execute(['id' => $id]);
$anggota = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$anggota) {
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Data anggota tidak ditemukan!'];
    header('Location: list.php');
    exit;
}
?>

<section class="form-section">
    <h2>Edit Anggota</h2>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-<?php echo $_SESSION['flash']['type']; ?>">
            <?php 
                echo htmlspecialchars($_SESSION['flash']['pesan']); 
                unset($_SESSION['flash']);
            ?>
        </div>
    <?php endif; ?>

    <form method="post" action="proses_edit.php" onsubmit="return confirm('Apakah Anda yakin ingin menyimpan perubahan data anggota ini?');">
        <input type="hidden" name="id" value="<?php echo $anggota['id']; ?>">

        <div class="form-group">
            <label for="no_anggota">No. Anggota / NIM</label>
            <input type="text" id="no_anggota" name="no_anggota" value="<?php echo htmlspecialchars($anggota['no_anggota'] ?? $anggota['nim'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="nama">Nama Anggota *</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($anggota['nama'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat / Email *</label>
            <input type="text" id="alamat" name="alamat" value="<?php echo htmlspecialchars($anggota['alamat'] ?? $anggota['email'] ?? ''); ?>"
        </div>

        <div class="form-group">
            <label for="no_hp">No. HP / Telepon</label>
            <input type="text" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($anggota['no_hp'] ?? $anggota['telepon'] ?? ''); ?>">
        </div>

        <div class="form-actions" style="margin-top: 15px; display: flex; gap: 8px; align-items: center;">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          <a href="list.php" class="btn-hapus">Batal</a>
        </div>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>