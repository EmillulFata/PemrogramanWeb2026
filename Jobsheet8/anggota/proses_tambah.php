<?php
session_start();
require_once __DIR__ . '/../includes/koneksi.php';

// Ambil dan bersihkan data input dari form
$no_anggota = trim($_POST['no_anggota'] ?? '');
$nama       = trim($_POST['nama'] ?? '');
$telepon    = trim($_POST['telepon'] ?? ''); // dari input form name="telepon"
$alamat     = trim($_POST['alamat'] ?? '');

$errors = [];

// Validasi Form
if ($no_anggota === '') {
    $errors[] = "Nomor Anggota wajib diisi.";
} elseif (!preg_match('/^[a-zA-Z0-9-]+$/', $no_anggota)) {
    $errors[] = "Nomor Anggota hanya boleh berisi huruf, angka, dan tanda hubung.";
}

if ($nama === '') {
    $errors[] = "Nama Lengkap wajib diisi.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type'  => 'danger',
        'pesan' => implode(' ', $errors)
    ];
    header('Location: tambah.php');
    exit;
}

// Simpan ke Database
// try {
//     // Memakai kolom no_anggota, nama, no_hp, dan alamat (email dihapus)
//     $sql = "INSERT INTO anggota (no_anggota, nama, no_hp, alamat) 
//             VALUES (:no_anggota, :nama, :no_hp, :alamat)";
            
//     $stmt = $pdo->prepare($sql);
//     $stmt->execute([
//         ':no_anggota' => $no_anggota,
//         ':nama'       => $nama,
//         ':no_hp'      => $telepon !== '' ? $telepon : null,
//         ':alamat'     => $alamat !== '' ? $alamat : null,
//     ]);

//     $_SESSION['flash'] = [
//         'type'  => 'success',
//         'pesan' => 'Anggota berhasil ditambahkan.'
//     ];
//     header('Location: list.php');
//     exit;

// } catch (PDOException $e) {
//     // Tangani error UNIQUE constraint (23505) untuk no_anggota
//     if ($e->getCode() == '23505') {
//         $_SESSION['flash'] = [
//             'type'  => 'danger',
//             'pesan' => 'No. Anggota sudah dipakai, gunakan nomor lain.'
//         ];
//     } else {
//         $_SESSION['flash'] = [
//             'type'  => 'danger',
//             'pesan' => 'Gagal menyimpan data: ' . $e->getMessage()
//         ];
//     }

// Soal 1
try {
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

    header('Location: tambah.php');
    exit;
}