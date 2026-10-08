<?php
$page_title = 'Tambah Buku';
require_once __DIR__ . '/../includes/header.php';
?>

<h2>Tambah Buku Baru</h2>

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
        <label for="judul">Judul Buku <span class="required">*</span></label>
        <input type="text" id="judul" name="judul" required>
    </div>

    <div class="form-control">
        <label for="pengarang">Pengarang <span class="required">*</span></label>
        <input type="text" id="pengarang" name="pengarang" required>
    </div>

    <div class="form-control">
        <label for="tahun">Tahun Terbit <span class="required">*</span></label>
        <input type="number" id="tahun" name="tahun" min="1900" max="2026" required>
    </div>

    <div class="form-control">
        <label for="isbn">ISBN</label>
        <input type="text" id="isbn" name="isbn" placeholder="Contoh: 978-602-03-8580-8">
    </div>

    <div class="form-control">
        <label for="stok">Stok <span class="required">*</span></label>
        <input type="number" id="stok" name="stok" min="0" value="1" required>
    </div>

    <div class="form-control">
        <label for="kategori">Kategori</label>
        <input type="text" id="kategori" name="kategori">
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Simpan Buku</button>
        <a href="list.php" class="btn btn-secondary">Batal</a>
    </div>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>