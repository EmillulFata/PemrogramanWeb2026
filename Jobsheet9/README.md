1. Tambah konfirmasi ekstra sebelum Update, bandingkan dengan Delete yang sudah punya confirm(); apakah Update juga butuh konfirmasi serupa? Pertimbangkan
   kapan konfirmasi tambahan benar-benar diperlukan (ingat: Update tidak destruktif seperti Delete, data lama masih "terlihat" sebelum diubah). 
2. Ubah jumlah baris per halaman, ganti $perPage = 5; menjadi 10 di buku/list.php, amati bagaimana jumlah total halaman berubah mengikuti. 
3. Tambah pencarian di kolom lain, misalnya perluas query di bab 5 §5.6 supaya juga mencocokkan kolom pengarang, bukan cuma judul (petunjuk: gunakan OR di
   klausa WHERE).

Jawab :
1. ```
<form method="post" action="proses_edit.php" onsubmit="return confirm('Apakah Anda yakin ingin menyimpan perubahan data ini?');">
   ```

2. ```
$perPage = 10;
   ```

3. ```
    if ($keyword !== '') {
        $hitung = $pdo->prepare("SELECT COUNT(*) FROM buku WHERE judul ILIKE :kw OR pengarang ILIKE :kw");
        $hitung->execute(['kw' => '%' . $keyword . '%']);
        $totalRows = $hitung->fetchColumn();

        $stmt = $pdo->prepare("SELECT * FROM buku WHERE judul ILIKE :kw OR pengarang ILIKE :kw ORDER BY id DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue('kw', '%' . $keyword . '%');
    } else {
        $totalRows = $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();
        $stmt = $pdo->prepare("SELECT * FROM buku ORDER BY id DESC LIMIT :limit OFFSET :offset");
    } 
    ```