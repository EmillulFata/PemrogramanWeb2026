<?php
$page_title = 'Edit Buku';
$base = '../';
require_once __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'ID buku tidak valid!'];
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM buku WHERE id = :id");
$stmt->execute(['id' => $id]);
$buku = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$buku) {
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Data buku tidak ditemukan!'];
    header('Location: list.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul     = trim($_POST['judul'] ?? '');
    $pengarang = trim($_POST['pengarang'] ?? '');
    $tahun     = (int) ($_POST['tahun'] ?? 0);
    $isbn      = trim($_POST['isbn'] ?? '');
    $stok       = (int) ($_POST['stok'] ?? 0);
    $kategori  = trim($_POST['kategori'] ?? '');

    if (empty($judul) || empty($pengarang) || empty($tahun)) {
        $error = "Judul, Pengarang, dan Tahun Terbit wajib diisi!";
    } else {
        $sql = "UPDATE buku 
                SET judul = :judul, 
                    pengarang = :pengarang, 
                    tahun = :tahun, 
                    isbn = :isbn, 
                    stok = :stok, 
                    kategori = :kategori 
                WHERE id = :id";
        
        $stmtUpdate = $pdo->prepare($sql);
        $stmtUpdate->execute([
            'judul'     => $judul,
            'pengarang' => $pengarang,
            'tahun'     => $tahun,
            'isbn'      => $isbn,
            'stok'      => $stok,
            'kategori'  => $kategori,
            'id'        => $id
        ]);

        $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data buku berhasil diperbarui!'];
        header('Location: list.php');
        exit;
    }
}
?>

<section class="form-section">
    <h2>Edit Buku</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="post" action="proses_edit.php" onsubmit="return confirm('Apakah Anda yakin ingin menyimpan perubahan data buku ini?');">
        <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">
        <div class="form-group">
            <label for="judul">Judul Buku *</label>
            <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($_POST['judul'] ?? $buku['judul']); ?>" required>
        </div>

        <div class="form-group">
            <label for="pengarang">Pengarang *</label>
            <input type="text" id="pengarang" name="pengarang" value="<?php echo htmlspecialchars($_POST['pengarang'] ?? $buku['pengarang']); ?>" required>
        </div>

        <div class="form-group">
            <label for="tahun">Tahun Terbit *</label>
            <input type="number" id="tahun" name="tahun" value="<?php echo htmlspecialchars((string)($_POST['tahun'] ?? $buku['tahun'])); ?>" required>
        </div>

        <div class="form-group">
            <label for="isbn">ISBN</label>
            <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($_POST['isbn'] ?? ($buku['isbn'] ?? '')); ?>" placeholder="Contoh: 978-602-03-8580-8">
        </div>

        <div class="form-group">
            <label for="stok">Stok *</label>
            <input type="number" id="stok" name="stok" value="<?php echo htmlspecialchars((string)($_POST['stok'] ?? $buku['stok'])); ?>" required>
        </div>

        <div class="form-group">
            <label for="kategori">Kategori</label>
            <input type="text" id="kategori" name="kategori" value="<?php echo htmlspecialchars($_POST['kategori'] ?? ($buku['kategori'] ?? '')); ?>">
        </div>

        <div class="form-actions" style="margin-top: 15px; display: flex; gap: 8px; align-items: center;">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="list.php" class="btn-hapus">Batal</a>
        </div>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>