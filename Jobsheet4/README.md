1. Gambar wireframe halaman baru memakai konvensi ASCII yang sama (bab 2 §2.2), misalnya 
   halaman "Registrasi Anggota Baru" untuk aktor Tamu yang ingin jadi anggota perpustakaan. 
   Jobsheet 3 & 4 — SIMPUS-Mini    |    hal. 33 
2. Buat user flow baru untuk skenario yang belum digambarkan di wireframe.md, misalnya: 
   "Petugas mencari anggota yang tunggakannya sudah lewat jatuh tempo." 
3. Identifikasi edge case tambahan yang mungkin belum tercatat, contoh: apa yang terjadi kalau 
   Petugas mencoba meminjamkan buku yang sama ke anggota yang sama dua kali berturut turut? 
4. Coba implementasikan wireframe Login sebagai HTML statis (tanpa logika login sungguhan, 
   mirip form Tambah Buku yang belum diproses di jobsheet-01) sebagai latihan menerjemahkan 
   wireframe ke kode nyata, gunakan pola <label> + <input> yang sudah kamu kuasai dari dokumentasi jobsheet-01, ditambah satu <input type="password"> baru untuk field Password.

Jawab
1. Desain Wireframe ASCII: Registrasi Anggota Baru
-. Wireframe ASCII berfungsi sebagai blueprint tata letak (layout) sebelum diimplementasikan ke kode HTML. Halaman registrasi dirancang khusus untuk aktor Tamu dengan menyediakan kolom input data diri dan kata sandi.
-. Elemen Header & Navigasi: Menampilkan nama aplikasi dan akses menu publik (Beranda, Login, Registrasi).
-. Formulir Input: Menggunakan field standar seperti Nama Lengkap, Nomor Identitas, Email, Telepon, Alamat, serta dua field Password untuk keamanan validasi pendaftaran.
-. Tombol Aksi: Menyediakan tombol utama [ Daftar Sekarang ] dan tombol pembatalan [ Batal ].

2. User Flow menggambarkan alur langkah logis yang dilalui oleh aktor Petugas dalam menyelesaikan tugas spesifik di dalam sistem.
-. Akses Menu: Petugas masuk ke modul laporan peminjaman.
-. Filtrasi Data: Petugas menerapkan filter status "Jatuh Tempo" untuk memisahkan transaksi yang terlambat dari peminjaman aktif.
-. Penyajian Data: Sistem menampilkan daftar seluruh transaksi peminjaman yang telah melewati batas tanggal pengembalian.
-. Pemeriksaan Detail: Petugas memilih salah satu nama anggota untuk melihat rincian jumlah denda dan informasi kontak aktif (WhatsApp/Email).
-. Eksekusi Tindakan: Petugas mengirimkan notifikasi pengingat atau mencetak lembar tagihan denda.

3. Edge cases adalah kondisi ekstrem atau skenario tidak terduga yang dapat memicu bug/error jika tidak diantisipasi sejak tahap perancangan.
A. Peminjaman Buku Ganda oleh Anggota Sama:
   -. Skenario: Petugas tidak sengaja menginput judul buku yang sama untuk anggota yang belum mengembalikan buku tersebut.
   -. Solusi: Sistem wajib memvalidasi status pinjaman anggota dan menolak transaksi dengan pesan peringatan.
B. Penghapusan Anggota Bermasalah:
   -. Skenario: Akun anggota dihapus padahal masih membawa buku atau memiliki denda tertunggak.
   -. Solusi: Sistem mengunci fungsi hapus (disable/block) selama anggota masih memiliki kewajiban aktif.
C. Bentrokan Stok Fisik Terakhir:
   -. Skenario: Dua petugas menginput peminjaman untuk satu-satunya eksemplar buku yang tersisa secara bersamaan.
   -. Solusi: Validasi stok dilakukan secara real-time saat tombol simpan ditekan, sehingga transaksi kedua otomatis dibatalkan.

4. Menerjemahkan rancangan wireframe menjadi bentuk HTML statis menggunakan pola elemen dasar:
A. Struktur <label> dan <input>: Menghubungkan label teks dengan kolom input menggunakan atribut for
   dan id agar accessible dan ramah pengguna.
B. Field Password Khusus: Menggunakan atribut <input type="password"> sehingga karakter yang diketik
   pengguna disamarkan secara otomatis demi keamanan.
C. Atribut required: Memastikan form tidak bisa dikirim dalam keadaan kosong tanpa perlu bantuan skrip
   tingkat tinggi.