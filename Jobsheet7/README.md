1. Tambah validasi ISBN di buku/proses_tambah.php, misalnya memastikan ISBN yang diisi (kalau tidak kosong) hanya berisi angka dan tanda hubung, memakai fungsi PHP 
   preg_match().
2. Tambah flash message di anggota/proses_tambah.php untuk kasus yang belum ditangani. Bandingkan dengan versi buku/proses_tambah.php yang sudah divalidasi lebih lengkap 
   (rentang tahun, stok non-negatif), field apa lagi di form anggota yang mungkin perlu aturan validasi tambahan? 

Jawab :
1. Pada file buku/proses_tambah.php, kita menambahkan fungsi preg_match() untuk memeriksa variabel $isbn. Jika variabel ini diisi (tidak kosong), kita memastikan
   formatnya hanya mengandung angka dan tanda hubung (-).
   Code : if ($isbn !== '' && !preg_match('/^[0-9-]+$/', $isbn)) {
    $errors[] = "ISBN hanya boleh berisi angka dan tanda hubung (-).";
  }

2. $_SESSION['flash'] = [
    'type'  => 'success',
    'pesan' => 'Anggota berhasil ditambahkan.'
  ];