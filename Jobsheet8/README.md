1. Tangani error UNIQUE dengan rapi, bungkus $stmt->execute(...) di anggota/proses_tambah.php dengan try/catch (PDOException $e), lalu set 
   $_SESSION['flash'] berisi pesan seperti "No. Anggota sudah dipakai, gunakan nomor lain." alih-alih membiarkan error mentah ditampilkan ke pengguna. 
2. Tambah kolom baru, misalnya tanggal_ditambahkan TIMESTAMP DEFAULT NOW() di tabel buku (cari tahu sendiri arti NOW() dan TIMESTAMP lewat dokumentasi PostgreSQL), lalu 
   tampilkan kolom itu di buku/list.php. 
3. Buat query pencarian di server, tambahkan WHERE judul ILIKE :keyword (ILIKE = pencocokan teks tanpa memandang huruf besar/kecil di PostgreSQL) ke query SELECT di buku/list.php,
   dihubungkan dengan kolom pencarian yang sudah ada di HTML, bandingkan dengan filter tabel sisi klien yang sudah kamu bangun di dokumentasi jobsheet-05 §6. 
4. Migrasi data lama, coba tulis skrip PHP kecil terpisah yang membaca data/buku.json dari jobsheet-06 (dokumentasi jobsheet-06 §3) lalu memasukkan seluruh isinya ke tabel buku 
   lewat INSERT, latihan bagus untuk memahami bagaimana data lama bisa "dipindahkan" ke database baru. 

Jawab:
1. try {
    $stmt->execute([
        ':no_anggota' => $no_anggota,
        ':nama'       => $nama,
        // masukan parameter lain
    ]);

    $_SESSION['flash'] = "Data anggota berhasil ditambahkan.";
    header("Location: list.php");
    exit;

} catch (PDOException $e) {
    // Check error code 23505 (Unique Violation)
    if ($e->getCode() == '23505') {
        $_SESSION['flash'] = "No. Anggota sudah dipakai, gunakan nomor lain.";
    } else {
        $_SESSION['flash'] = "Gagal menyimpan data: " . $e->getMessage();
    }

2. ALTER TABLE buku 
ADD COLUMN tanggal_ditambahkan TIMESTAMP DEFAULT NOW();
<!-- Header Tabel -->
<th>Tanggal Ditambahkan</th>
<!-- Baris Tabel (di dalam loop foreach/while) -->
<td><?= date('d-m-Y H:i', strtotime($row['tanggal_ditambahkan'])) ?></td>

3. buku/list.php
$keyword = $_GET['keyword'] ?? '';

if (!empty($keyword)) {
    $sql = "SELECT * FROM buku WHERE judul ILIKE :keyword ORDER BY id DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute([':keyword' => '%' . $keyword . '%']);
} else {
    $sql = "SELECT * FROM buku ORDER BY id DESC";
    $stmt = $db->query($sql);
}
$daftar_buku = $stmt->fetchAll(PDO::FETCH_ASSOC);


4. <?php
require_once 'koneksi.php';

$json_file = 'data/buku.json';

if (!file_exists($json_file)) {
    die("File JSON tidak ditemukan.");
}

$json_data = file_get_contents($json_file);
$buku_list = json_decode($json_data, true);

if (empty($buku_list)) {
    die("Data JSON kosong atau tidak valid.");
}

$sql = "INSERT INTO buku (judul, pengarang, penerbit, tahun_terbit) VALUES (:judul, :pengarang, :penerbit, :tahun_terbit)";
$stmt = $db->prepare($sql);

$berhasil = 0;

foreach ($buku_list as $buku) {
    try {
        $stmt->execute([
            ':judul'        => $buku['judul'] ?? '',
            ':pengarang'    => $buku['pengarang'] ?? '',
            ':penerbit'     => $buku['penerbit'] ?? '',
            ':tahun_terbit' => $buku['tahun_terbit'] ?? NULL
        ]);
        $berhasil++;
    } catch (PDOException $e) {
        echo "Gagal migrasi buku: " . ($buku['judul'] ?? '') . " - " . $e->getMessage() . "<br>";
    }
}
