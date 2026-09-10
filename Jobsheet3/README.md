1. Tambah breakpoint baru, misalnya @media (min-width: 1400px) untuk layar monitor sangat 
   lebar, ubah main { max-width: 1000px; } (dari dokumentasi jobsheet-02) menjadi lebih lebar 
   khusus di breakpoint ini. 
2. Ubah breakpoint tablet dari 768px menjadi 900px, lalu amati di lebar layar berapa susunan 
   kartu berubah, buktikan bahwa breakpoint memang bisa disesuaikan bebas sesuai kebutuhan desain. 
3. Terapkan pola table-responsive ke elemen lain yang berpotensi melebar di layar sempit, 
   misalnya kalau suatu saat kamu menambahkan blok kode <pre> yang panjang di salah satu halaman. 
4. Ubah posisi ikon hamburger, misalnya pindahkan .nav-toggle-label ke urutan terakhir di 
   <header> (setelah <nav>) lalu amati apakah sibling combinator .nav-toggle:checked ~ nav di bab 3 §3.5 
   masih bekerja, combinator ~ mensyaratkan target berada setelah elemen sumbernya di HTML. 
5. Bandingkan dengan pendekatan mobile-first, coba tulis ulang style.css dari nol memakai 
   @media (min-width: ...) alih-alih max-width, dan rasakan sendiri bedanya alur berpikirnya. 

Jawab :
1. @media (min-width: 1400px): Ditambahkan di bagian paling bawah untuk memperlebar main dari 1000px menjadi 1300px
   saat dibuka di monitor layar lebar.
2. (Breakpoint Tablet 900px): @media (min-width: 900px) menggantikan 768px. Kartu statistik kini berpindah dari 1
   kolom ke 2 kolom tepat pada ukuran layar 900px.
3. (Elemen Responsif Lain): Dibuatkan kelas .code-responsive dengan aturan overflow-x: auto untuk membungkus elemen
   <pre><code> agar blok kode panjang tidak merusak tata letak.
4. (Aturan Sibling Combinator): Selektor .nav-toggle:checked ~ nav menuntut elemen <input id="nav-toggle"> diletakkan
   sebelum <nav> di struktur HTML. Jika .nav-toggle-label (ikonnya) dipindah ke paling bawah header, tombol hamburger tetap bekerja selama <input> tetap berada di atas <nav>.
5. (Pendekatan Mobile-First): CSS ditulis ulang penuh dari gaya dasar mobile (0-899px), lalu ditingkatkan secara
   bertahap menggunakan @media (min-width: ) (Progressive Enhancement).