<?php 
session_start(); 

$id = $_POST['id'] ?? null; 
// ...ambil field lain dari $_POST, validasi (identik dengan proses_tambah.php)... 
if (!$id) { 
header('Location: list.php'); 
exit; 
}
// ...kalau ada error validasi, redirect ke edit.php?id=... (bukan tambah.php)... 
$stmt = $pdo->prepare( 
"UPDATE buku SET judul = :judul, pengarang = :pengarang, tahun = :tahun, 
isbn = :isbn, stok = :stok, kategori = :kategori WHERE id = :id" 
); 
$stmt->execute([ 
'judul' => $judul, 
'pengarang' => $pengarang, 
'tahun' => (int) $tahun, 
'isbn' => $isbn, 
'stok' => (int) $stok, 
'kategori' => $kategori, 
'id' => $id, 
]);