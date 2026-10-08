<?php 
session_start(); 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}

// Ambil data dari form dan hilangkan spasi di awal/akhir
$judul     = trim($_POST['judul'] ?? ''); 
$pengarang = trim($_POST['pengarang'] ?? ''); 
$tahun     = $_POST['tahun'] ?? ''; 
$isbn      = trim($_POST['isbn'] ?? ''); 
$stok      = $_POST['stok'] ?? ''; 
$kategori  = trim($_POST['kategori'] ?? '');

$errors = []; 

// Validasi Input
if ($judul === '') { 
    $errors[] = "Judul wajib diisi."; 
} 

if ($pengarang === '') { 
    $errors[] = "Pengarang wajib diisi."; 
} 

if (filter_var($tahun, FILTER_VALIDATE_INT) === false || $tahun < 1900 || $tahun > (int) date('Y')) { 
    $errors[] = "Tahun harus di antara 1900-" . date('Y') . "."; 
} 

if (filter_var($stok, FILTER_VALIDATE_INT) === false || $stok < 0) { 
    $errors[] = "Stok tidak boleh negatif."; 
} 

if ($isbn !== '' && !preg_match('/^[0-9-]+$/', $isbn)) {
    $errors[] = "ISBN hanya boleh berisi angka dan tanda hubung (-).";
}

// Jika ada error, simpan pesan ke session dan kembalikan ke form tambah
if (!empty($errors)) { 
    $_SESSION['flash'] = [
        'type'  => 'error', 
        'pesan' => implode(' ', $errors)
    ]; 
    header('Location: tambah.php'); 
    exit; 
} 

require __DIR__ . '/../includes/koneksi.php'; 

$stmt = $pdo->prepare( 
    "INSERT INTO buku (judul, pengarang, tahun, isbn, stok, kategori) 
     VALUES (:judul, :pengarang, :tahun, :isbn, :stok, :kategori) 
     RETURNING id" 
); 
$stmt->execute([ 
    'judul' => $judul, 
    'pengarang' => $pengarang, 
    'tahun' => (int) $tahun, 
    'isbn' => $isbn, 
    'stok' => (int) $stok, 
    'kategori' => $kategori, 
]); 

// Simpan notifikasi sukses dan arahkan ke halaman daftar buku
$_SESSION['flash'] = [
    'type'  => 'success', 
    'pesan' => 'Buku berhasil ditambahkan.'
]; 


header('Location: list.php'); 
exit;

