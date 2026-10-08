<?php
$page_title = 'Daftar Buku';
$base = '../';
require_once __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$keyword = trim($_GET['keyword'] ?? '');

$perPage = 5; 
$page = max(1, (int) ($_GET['page'] ?? 1)); 
$offset = ($page - 1) * $perPage; 

if ($keyword !== '') {
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM buku WHERE judul ILIKE :kw OR pengarang ILIKE :kw");
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = $hitung->fetchColumn();

    $stmt = $pdo->prepare("SELECT * FROM buku WHERE judul ILIKE :kw OR pengarang ILIKE :kw ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    $totalRows = $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();
    $stmt = $pdo->prepare("SELECT * FROM buku ORDER BY id DESC LIMIT :limit OFFSET :offset");
} 

$stmt->bindValue('limit', $perPage, PDO::PARAM_INT); 
$stmt->bindValue('offset', $offset, PDO::PARAM_INT); 
$stmt->execute(); 

$daftarBuku = $stmt->fetchAll(PDO::FETCH_ASSOC); 
$totalPages = max(1, (int) ceil($totalRows / $perPage)); 
?>

<section>
    <div class="header-action">
        <h2>Daftar Buku</h2>
    </div>

    <div class="search-box" style="margin: 15px 0;">
        <form method="get" action="list.php" style="display: flex; gap: 8px; align-items: center;">
            <input type="text" name="keyword" placeholder="Cari judul/pengarang..." value="<?php echo htmlspecialchars($keyword); ?>">
            <button type="submit" class="btn btn-primary">Cari</button>
            <?php if ($keyword !== ''): ?>
                <a href="list.php" class="btn btn-secondary">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-<?php echo $_SESSION['flash']['type']; ?>">
            <?php 
                echo htmlspecialchars($_SESSION['flash']['pesan']); 
                unset($_SESSION['flash']);
            ?>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($daftarBuku)): ?>
                    <?php foreach ($daftarBuku as $index => $buku): ?>
                        <tr>
                            <td><?php echo $offset + $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($buku['judul']); ?></td>
                            <td><?php echo htmlspecialchars($buku['pengarang']); ?></td>
                            <td><?php echo htmlspecialchars((string) $buku['tahun']); ?></td>
                            <td><?php echo htmlspecialchars((string) ($buku['isbn'] ?? '-')); ?></td>
                            <td><?php echo htmlspecialchars((string) $buku['stok']); ?></td>
                            <td><?php echo htmlspecialchars((string) ($buku['kategori'] ?? '-')); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $buku['id']; ?>" class="btn-edit">Edit</a>

                                    <form method="post" action="hapus.php" style="display: inline;">
                                        <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">
                                        <button type="submit" class="btn-hapus" onclick="return confirm('Yakin hapus data ini?');">Hapus</button>
                                        </form>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center;">Belum ada data buku yang cocok.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <nav class="pagination" style="margin-top: 15px;">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="list.php?page=<?php echo $i; ?><?php echo $keyword !== '' ? '&keyword=' . urlencode($keyword) : ''; ?>"
               class="<?php echo $i === $page ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </nav>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>