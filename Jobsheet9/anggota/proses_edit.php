<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id      = (int) ($_POST['id'] ?? 0);
    $nim     = trim($_POST['nim'] ?? '');
    $nama    = trim($_POST['nama'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $telepon = trim($_POST['telepon'] ?? '');

    if ($id <= 0) {
        $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'ID anggota tidak valid!'];
        header('Location: list.php');
        exit;
    }

    if (empty($nama) || empty($email)) {
        $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Nama dan Email wajib diisi!'];
        header("Location: edit.php?id=" . $id);
        exit;
    }

    $sql = "UPDATE anggota 
            SET nim = :nim, 
                nama = :nama, 
                email = :email, 
                telepon = :telepon 
            WHERE id = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nim'     => $nim,
        'nama'    => $nama,
        'email'   => $email,
        'telepon' => $telepon,
        'id'      => $id
    ]);

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data anggota berhasil diperbarui!'];
    header('Location: list.php');
    exit;
} else {
    header('Location: list.php');
    exit;
}