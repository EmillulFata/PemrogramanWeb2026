<?php
$page_title = "Beranda";
include __DIR__ . '/includes/header.php';

// Hitung total buku dan anggota dari session secara dinamis
$totalBuku    = count($_SESSION['buku'] ?? []);
$totalAnggota = count($_SESSION['anggota'] ?? []);
?>

<section id="beranda">
    <h2>Selamat Datang di SIMPUS-Mini</h2>
    <p>
        Sistem Informasi Manajemen Perpustakaan Sederhana untuk pengelolaan data buku dan anggota secara praktis.
    </p>
</section>

<section id="ringkasan">
    <h2>Ringkasan Data</h2>
    <article>
        <h3>Total Buku</h3>
        <p id="stat-buku"><?php echo $totalBuku; ?></p>
    </article>
    <article>
        <h3>Total Anggota</h3>
        <p id="stat-anggota"><?php echo $totalAnggota; ?></p>
    </article>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>