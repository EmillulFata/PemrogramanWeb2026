<?php
$page_title = "Daftar Anggota";
$base = '../';
require_once __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

// Ambil parameter keyword pencarian
$keyword = trim($_GET['keyword'] ?? '');

// Konfigurasi Pagination
$perPage = 5;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;

if ($keyword !== '') {
    // Hitung total data berdasarkan keyword
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM anggota WHERE nama ILIKE :kw OR no_anggota ILIKE :kw OR alamat ILIKE :kw");
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = $hitung->fetchColumn();

    // Query data dengan limit & offset
    $stmt = $pdo->prepare("SELECT * FROM anggota WHERE nama ILIKE :kw OR no_anggota ILIKE :kw OR alamat ILIKE :kw ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    $totalRows = $pdo->query("SELECT COUNT(*) FROM anggota")->fetchColumn();
    $stmt = $pdo->prepare("SELECT * FROM anggota ORDER BY id DESC LIMIT :limit OFFSET :offset");
}

$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$daftarAnggota = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalPages = max(1, (int) ceil($totalRows / $perPage));
?>

<section>
  <div class="header-action">
    <h2>Daftar Anggota</h2>
    <a href="tambah.php" class="btn btn-primary">Tambah Anggota Baru</a>
  </div>

  <?php if (isset($_SESSION['flash'])): ?>
    <div class="flash flash-<?php echo $_SESSION['flash']['type']; ?>">
      <?php 
        echo htmlspecialchars($_SESSION['flash']['pesan']); 
        unset($_SESSION['flash']);
      ?>
    </div>
  <?php endif; ?>

  <div class="search-box" style="margin: 15px 0;">
    <form method="get" action="list.php" style="display: flex; gap: 8px; align-items: center;">
      <input type="text" name="keyword" placeholder="Ketik nama / no. anggota..." value="<?php echo htmlspecialchars($keyword); ?>">
      <button type="submit" class="btn btn-primary">Cari</button>
      <?php if ($keyword !== ''): ?>
        <a href="list.php" class="btn btn-secondary">Reset</a>
      <?php endif; ?>
    </form>
  </div>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>No. Anggota</th>
          <th>Nama</th>
          <th>Alamat</th>
          <th>No. HP</th>
          <th>Email</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($daftarAnggota)): ?>
          <tr>
            <td colspan="5" style="text-align: center;">Belum ada data anggota yang cocok.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($daftarAnggota as $anggota): ?>
            <tr>
              <td><?php echo htmlspecialchars($anggota['no_anggota'] ?? '-'); ?></td>
              <td><?php echo htmlspecialchars($anggota['nama']); ?></td>
              <td><?php echo htmlspecialchars($anggota['alamat'] ?? '-'); ?></td>
              <td><?php echo htmlspecialchars($anggota['no_hp'] ?? '-'); ?></td>
              <td><?php echo htmlspecialchars($anggota['email'] ?? '-'); ?></td>
              <td>
                <a href="edit.php?id=<?php echo $anggota['id']; ?>" class="btn-edit">Edit</a>
                
                <form method="post" action="hapus.php" style="display: inline;">
                  <input type="hidden" name="id" value="<?php echo $anggota['id']; ?>">
                  <button type="submit" class="btn-hapus" onclick="return confirm('Yakin hapus data anggota ini?');">Hapus</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
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