<?php
$page_title = 'Daftar Buku';
require_once __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$keyword = $_GET['keyword'] ?? '';

if (!empty($keyword)) {
    $sql = "SELECT * FROM buku WHERE judul ILIKE :keyword ORDER BY id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':keyword' => '%' . $keyword . '%']);
} else {
    $sql = "SELECT * FROM buku ORDER BY id DESC";
    $stmt = $pdo->query($sql);
}

$daftarBuku = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="header-action">
    <h2>Daftar Buku</h2>
    <a href="tambah.php" class="btn btn-primary">Tambah Buku Baru</a>
    <a href="../index.php" class="btn btn-secondary">Kembali ke Beranda</a>
</div>

<form method="GET" style="margin: 15px 0; display: flex; gap: 8px;">
    <input type="text" name="keyword" placeholder="Cari judul/pengarang..." value="<?= htmlspecialchars($keyword) ?>">
    <button type="submit" class="btn btn-primary">Cari</button>
    <?php if ($keyword): ?>
        <a href="list.php" class="btn btn-secondary">Reset</a>
    <?php endif; ?>
</form>

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
            <th>Tanggal Ditambahkan</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($daftarBuku)): ?>
            <?php foreach ($daftarBuku as $index => $buku): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($buku['judul']); ?></td>
                    <td><?php echo htmlspecialchars($buku['pengarang']); ?></td>
                    <td><?php echo htmlspecialchars((string) $buku['tahun']); ?></td>
                    <td><?php echo htmlspecialchars((string) ($buku['isbn'] ?? '')); ?></td>
                    <td><?php echo htmlspecialchars((string) $buku['stok']); ?></td>
                    <td><?php echo htmlspecialchars((string) ($buku['kategori'] ?? '')); ?></td>
                    <td><?= !empty($buku['tanggal_ditambahkan']) 
                    ? date('d-m-Y H:i', strtotime($buku['tanggal_ditambahkan'])) 
        : '-' ?></td>
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