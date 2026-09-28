<?php
$page_title = 'Daftar Buku';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="header-action">
    <h2>Daftar Buku</h2>
    <!-- PASTIKAN KEDUA LINK DI BAWAH INI BERAKHIRAN .php BUKAN .html -->
    <a href="tambah.php" class="btn btn-primary">Tambah Buku Baru</a>
    <a href="../index.php" class="btn btn-secondary">Kembali ke Beranda</a>
</div>

<?php if (isset($_SESSION['flash'])): ?>
    <div class="alert alert-<?php echo $_SESSION['flash']['type']; ?>">
        <?php 
            echo htmlspecialchars($_SESSION['flash']['pesan']); 
            unset($_SESSION['flash']);
        ?>
    </div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Tahun</th>
            <th>ISBN</th>
            <th>Stok</th>
            <th>Kategori</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($_SESSION['buku'])): ?>
            <?php foreach ($_SESSION['buku'] as $index => $buku): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($buku['judul']); ?></td>
                    <td><?php echo htmlspecialchars($buku['pengarang']); ?></td>
                    <td><?php echo htmlspecialchars($buku['tahun']); ?></td>
                    <td><?php echo htmlspecialchars($buku['isbn']); ?></td>
                    <td><?php echo htmlspecialchars($buku['stok']); ?></td>
                    <td><?php echo htmlspecialchars($buku['kategori']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" style="text-align: center;">Belum ada data buku.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>