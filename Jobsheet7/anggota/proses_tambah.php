<?php
session_start();

// Ambil dan bersihkan data input dari form
$no_anggota = trim($_POST['no_anggota'] ?? '');
$nama       = trim($_POST['nama'] ?? '');
$email      = trim($_POST['email'] ?? '');
$telepon    = trim($_POST['telepon'] ?? '');
$alamat     = trim($_POST['alamat'] ?? '');

$errors = [];

// Validasi Nomor Anggota
if ($no_anggota === '') {
    $errors[] = "Nomor Anggota wajib diisi.";
} elseif (!preg_match('/^[a-zA-Z0-9-]+$/', $no_anggota)) {
    $errors[] = "Nomor Anggota hanya boleh berisi huruf, angka, dan tanda hubung.";
}

// Validasi Nama
if ($nama === '') {
    $errors[] = "Nama Lengkap wajib diisi.";
}

// Validasi Email
if ($email === '') {
    $errors[] = "Email wajib diisi.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Format email tidak valid.";
}

// Validasi Nomor Telepon
if ($telepon !== '' && !preg_match('/^\+?[0-9]{8,15}$/', $telepon)) {
    $errors[] = "Nomor telepon tidak valid (harus 8-15 digit angka).";
}

// Jika terdapat error validasi, kirim flash message error dan redirect
if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type'  => 'error',
        'pesan' => implode(' ', $errors)
    ];
    header('Location: tambah.php');
    exit;
}

// Inisialisasi array session anggota jika belum ada
if (!isset($_SESSION['anggota'])) {
    $_SESSION['anggota'] = [];
}

// Simpan data ke session
$_SESSION['anggota'][] = [
    'no_anggota' => $no_anggota,
    'nama'       => $nama,
    'email'      => $email,
    'telepon'    => $telepon,
    'alamat'     => $alamat,
];

// Set flash message sukses dan redirect ke daftar anggota (soal 2)
$_SESSION['flash'] = [
    'type'  => 'success',
    'pesan' => 'Anggota berhasil ditambahkan.'
];

header('Location: list.php');
exit;