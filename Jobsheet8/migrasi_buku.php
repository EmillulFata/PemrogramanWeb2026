<?php
require_once __DIR__ . '/includes/koneksi.php';

$json_file = 'data/buku.json';

if (!file_exists($json_file)) {
    die("File JSON tidak ditemukan.");
}

$json_data = file_get_contents($json_file);
$buku_list = json_decode($json_data, true);

if (empty($buku_list)) {
    die("Data JSON kosong atau tidak valid.");
}

$sql = "INSERT INTO buku (judul, pengarang, tahun, stok, kategori) VALUES (:judul, :pengarang, :tahun, :stok, :kategori)";
$stmt = $pdo->prepare($sql);

$berhasil = 0;

foreach ($buku_list as $buku) {
    try {
        $stmt->execute([
            ':judul'        => $buku['judul'] ?? '',
            ':pengarang'    => $buku['pengarang'] ?? '',
            ':tahun'         => $buku['tahun'] ?? NULL,
            ':stok'           => $buku['stok'] ?? 0,
            ':kategori'      => $buku['kategori'] ?? ''
        ]);
        $berhasil++;
    } catch (PDOException $e) {
        echo "Gagal migrasi buku: " . ($buku['judul'] ?? '') . " - " . $e->getMessage() . "<br>";
    }
}

echo "Migrasi selesai! Total $berhasil data berhasil dimasukkan ke tabel buku.";