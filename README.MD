1. Kenapa field "Alamat" dan "No. HP" tidak diberi required, sedangkan "Nama"
   dan "No. Anggota" diberi?
2. Apa yang akan terjadi (di browser) kalau kamu klik tombol "Simpan" tanpa
   mengisi field "Nama"? Coba buka filenya di browser dan praktikkan.
3. Form ini juga belum punya action pada tag <form>-nya — apa dampaknya saat
   tombol "Simpan" ditekan?

Jawab :

1. Karena "Nama" dan "No. Anggota" adalah identitas utama yang wajib diisi oleh
   klien, tanpa kedua data tersebut sistem tidak bisa mengenali siapa peminjam
   buku yang telah dipinjam sedangkan "Alamat" dan "No. HP" bersifat opsional (bisa diisi bisa tidak) karena bukan merupakan identitas utama dari peminjam yang akan menjadi keyword sistem mencari data dari si peminjam
2. Ketika saya meng-klik tombol simpan tanpa mengisi field nama maka yang
   terjadi adalah muncul pop-up "Please fill out this field" (Harap isi kolom ini)
3. Data yang diisikan lewat form/web tidak akan masuk ke Database karena belum
   ada action pada tag <form>, jadi walaupun sudah mengisi data dan meng-klik simpan, data terbaru tidak akan terbarui di webnya.
