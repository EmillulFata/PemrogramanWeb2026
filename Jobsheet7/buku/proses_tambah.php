<?php 
session_start(); 

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

if (!is_numeric($tahun) || $tahun < 1900 || $tahun > 2026) { 
    $errors[] = "Tahun harus di antara 1900-2026."; 
} 

if (!is_numeric($stok) || $stok < 0) { 
    $errors[] = "Stok tidak boleh negatif."; 
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

// SOal no 1 Validasi ISBN
if ($isbn !== '' && !preg_match('/^[0-9-]+$/', $isbn)) {
    $errors[] = "ISBN hanya boleh berisi angka dan tanda hubung (-).";
}

// Inisialisasi session buku jika belum ada
if (!isset($_SESSION['buku'])) { 
    $_SESSION['buku'] = []; 
} 

// Simpan data buku baru ke dalam session
$_SESSION['buku'][] = [ 
    'judul'     => $judul, 
    'pengarang' => $pengarang, 
    'tahun'     => (int) $tahun, 
    'isbn'      => $isbn, 
    'stok'      => (int) $stok, 
    'kategori'  => $kategori, 
]; 

// Simpan notifikasi sukses dan arahkan ke halaman daftar buku
$_SESSION['flash'] = [
    'type'  => 'success', 
    'pesan' => 'Buku berhasil ditambahkan.'
]; 


header('Location: list.php'); 
exit;

