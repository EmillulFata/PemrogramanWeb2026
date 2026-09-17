// ===== Hamburger menu (JS-driven) =====
function initNavToggle() {
  const toggleBtn = document.getElementById("nav-toggle-btn");
  const nav = document.querySelector("header nav");
  if (!toggleBtn || !nav) return;

  toggleBtn.addEventListener("click", function () {
    nav.classList.toggle("nav-open");

    console.log("knknnkn");
  });
}

// ===== Konfirmasi hapus (front-end only) =====
function initHapusConfirm() {
  document.querySelectorAll(".btn-hapus").forEach(function (btn) {
    btn.addEventListener("click", function () {
      const row = btn.closest("tr");
      const nama = row ? row.querySelector("td")?.textContent : "data ini";
      const yakin = confirm('Yakin ingin menghapus "' + nama + '"?');
      if (yakin && row) {
        row.remove();
      }
    });
  });
}

// ===== Filter/pencarian tabel real-time =====
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

// ===== Validasi form (client-side) =====
function tampilkanError(input, pesan) {
  hapusError(input);
  const span = document.createElement("span");
  span.className = "error";
  span.textContent = pesan;
  input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
  const next = input.nextElementSibling;
  if (next && next.classList.contains("error")) {
    next.remove();
  }
}

function initValidasiForm() {
  const form = document.getElementById("form-tambah");
  if (!form) return;

  form.addEventListener("submit", function (e) {
    let valid = true;

    const judul = form.querySelector("[name='judul'], [name='nama']");
    if (judul && judul.value.trim() === "") {
      tampilkanError(judul, "Field ini wajib diisi.");
      valid = false;
    } else if (judul) {
      hapusError(judul);
    }

    const isbn = form.querySelector("[name='isbn']");
    if (isbn && isbn.value.trim() !== "") {
      const isbnPattern = /^[0-9-]+$/;
      if (!isbnPattern.test(isbn.value.trim())) {
        tampilkanError(
          isbn,
          "ISBN hanya boleh berisi angka dan tanda hubung (-).",
        );
        valid = false;
      } else {
        hapusError(isbn);
      }
    }

    if (!valid) {
      e.preventDefault();
    }
  });
}
document.addEventListener("DOMContentLoaded", function () {
  initNavToggle();
  initHapusConfirm();
  initTableFilter();
  initValidasiForm();
});
