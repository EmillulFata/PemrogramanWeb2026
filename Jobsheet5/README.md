1. Tambah validasi field baru, field ISBN di form Tambah Buku (yang saat ini tidak wajib diisi, ingat dari 
   dokumentasi jobsheet-01 §4.4) validasi supaya hanya menerima angka dan tanda hubung. 
2. Tambah animasi sederhana pada initNavToggle, tambahkan class CSS transition pada header nav 
   di style.css supaya menu terbuka/tertutup dengan efek geser halus, alih-alih langsung muncul/hilang seketika. 
3. Perluas initTableFilter supaya pencarian bisa dibatasi ke satu kolom saja (misalnya hanya kolom 
   "Judul"), bukan mencari di seluruh teks baris,petunjuk: gunakan row.querySelector("td") seperti pola yang sudah dipakai di bab 5 §5.4.

Jawab :
1. Validasi ISBN
   const isbn = form.querySelector("[name='isbn']");
    if (isbn && isbn.value.trim() !== "") {
      const isbnPattern = /^[0-9-]+$/;
      if (!isbnPattern.test(isbn.value.trim())) {
        tampilkanError(isbn, "ISBN hanya boleh berisi angka dan tanda hubung (-).");
        valid = false;
      } else {
        hapusError(isbn);
      }
    }

2. Menambhakan animasi
     header nav {
    width: 100%;
    order: 3;
    margin-top: 1rem;
    max-height: 0;
    overflow: hidden;
    opacity: 0;
    transition: max-height 0.4s ease-in-out, opacity 0.3s ease-in-out;
  }

  header nav.nav-open {
    max-height: 300px;
    opacity: 1;
  }
}

3. Hanya dapat search judul
   function initTableFilter() {
  const input = document.getElementById("search-input");
  const table = document.querySelector(".table-responsive table") || document.querySelector("table");
  if (!input || !table) return;

  input.addEventListener("input", function () {
    const keyword = input.value.toLowerCase().trim();
    const rows = table.querySelectorAll("tbody tr");

    rows.forEach(function (row) {
      // Ambil kolom pertama saja (td paling awal)
      const kolomJudul = row.querySelector("td");
      
      if (kolomJudul) {
        const teksJudul = kolomJudul.textContent.toLowerCase();
        // Bandingkan keyword HANYA dengan teks di kolom pertama
        row.style.display = teksJudul.includes(keyword) ? "" : "none";
      }
    });
  });
}