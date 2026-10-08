<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) ($_POST['id'] ?? 0);

    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM anggota WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data anggota berhasil dihapus!'];
    } else {
        $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'ID anggota tidak valid!'];
    }
}

header('Location: list.php');
exit;