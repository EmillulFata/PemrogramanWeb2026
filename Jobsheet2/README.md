1. Ubah skema warna. Ganti nilai #1d5b8a (warna biru tema) di seluruh file style.css dengan warna lain, 
   misalnya hijau tua, lalu amati bagaimana warna itu konsisten muncul di header, judul section, tombol submit, dan header tabel, karena semuanya memakai nilai hex yang sama. 
2. Tambah kolom keempat. Di grid kartu statistik, tambahkan satu <article> baru di HTML (misalnya "Buku 
   Terlambat"), lalu ubah repeat(3, 1fr) menjadi repeat(4, 1fr) di CSS. 
3. Buat tombol ketiga di tabel. Tambahkan tombol "Detail" di antara Edit dan Hapus pada buku/list.html, 
   lalu amati apakah warnanya sesuai harapan (ingat catatan di bab 7 §7.6 tentang :first-of-type/:last of-type yang berbasis posisi, bukan makna). Coba perbaiki dengan memberi class khusus jika warnanya tidak sesuai. 
4. Uji responsivitas sederhana. Perkecil lebar jendela browser secara bertahap sampai sangat sempit (seperti 
   lebar HP), amati kapan flex-wrap: wrap pada navbar mulai memindahkan menu ke baris baru. 

Jawab :
1. Done
2. Done
3. Done
4. Hasil Pengamatan:
Pada saat lebar layar browser diperkecil secara bertahap hingga mencapai ukuran sempit, properti flex-wrap: wrap; pada elemen header bekerja secara otomatis. Menu navigasi (<nav>) berpindah ke baris baru tepat di bawah judul SIMPUS-Mini.

maka dari itu fungsi flex-wrap: wrap adalah untuk Mencegah elemen-elemen di dalam header saling bertabrakan atau terpotong keluar dari layar (overflow horizontal) saat diakses dari perangkat berlayar kecil seperti ponsel.