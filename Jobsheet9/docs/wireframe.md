# Rancangan Fitur SIMPUS-Mini (Jobsheet 04)

## 1. Wireframe ASCII: Registrasi Anggota Baru
## Wireframe untuk aktor Tamu yang ingin mendaftar menjadi anggota perpustakaan.

+-----------------------------------------------------------------------+
| SIMPUS-Mini                                   [Beranda] [Login] [Reg] |
+-----------------------------------------------------------------------+
|                                                                       |
| Formulir Registrasi Anggota Baru                                      |
| ---------------------------------------                               |
|                                                                       |
| Nama Lengkap                                                          |
| [                                                         ]           |
|                                                                       |
| Nomor Identitas (NIK / NIM / NIP)                                     |
| [                                                         ]           |
|                                                                       |
| Email                                                                 |
| [                                                         ]           |
|                                                                       |
| Nomor Telepon / WhatsApp                                              |
| [                                                         ]           |
|                                                                       |
| Alamat                                                                |
| [                                                         ]           |
| [                                                         ]           |
|                                                                       |
| Password                                                              |
| [                                                         ]           |
|                                                                       |
| Konfirmasi Password                                                   |
| [                                                         ]           |
|                                                                       |
| [ Daftar Sekarang ]      [ Batal ]                                    |
|                                                                       |
+-----------------------------------------------------------------------+
| © 2026 SIMPUS-Mini — Sistem Informasi Perpustakaan                    |
+-----------------------------------------------------------------------+

---

## 2. User Flow: Pencarian Anggota Menunggak / Jatuh Tempo

Skenario untuk Petugas yang ingin mencari anggota dengan keterlambatan pengembalian buku:

1. **Akses Menu**: Petugas membuka menu **Laporan / Peminjaman**.
2. **Filter Data**: Petugas memilih filter **Status: Jatuh Tempo** dan menentukan rentang tanggal peminjaman.
3. **Display Data**: Sistem menampilkan daftar anggota yang terlambat mengembalikan buku beserta durasi keterlambatan.
4. **Detail Anggota**: Petugas mengeklik nama **Anggota** untuk membuka detail tagihan dan informasi kontak (Email/WhatsApp).
5. **Tindakan**: Petugas mengeklik tombol **Kirim Pengingat** atau **Cetak Tagihan Denda**.

---

## 3. Dokumentasi Edge Cases

- **Peminjaman Ganda (Buku Sama & Anggota Sama)**:
  - _Masalah_: Petugas meminjamkan buku yang sama ke anggota yang sama dua kali berturut-turut.
  - _Penanganan_: Sistem menolak transaksi dengan notifikasi _"Anggota ini sedang meminjam eksemplar buku tersebut dan belum mengembalikannya."_

- **Penghapusan Anggota dengan Tanggungan Aktif**:
  - _Masalah_: Petugas mencoba menghapus akun anggota yang masih membawa buku atau memiliki denda belum lunas.
  - _Penanganan_: Sistem memblokir perintah hapus dan menampilkan pesan _"Anggota tidak dapat dihapus karena masih memiliki tanggungan pinjaman/denda aktif."_

- **Bentrokan Stok Peminjaman Serentak**:
  - _Masalah_: Dua petugas menginput peminjaman untuk buku fisik terakhir pada detik yang sama.
  - _Penanganan_: Sistem memvalidasi ketersediaan stok secara real-time saat tombol simpan diklik. Transaksi kedua akan dibatalkan otomatis dengan pesan _"Stok buku telah habis."_
