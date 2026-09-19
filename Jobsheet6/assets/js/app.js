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

// Memakai event delegation di document karena baris tabel sekarang
// dirender dinamis via fetch (lihat buku.js/anggota.js) sehingga
// tombol .btn-hapus belum tentu ada saat DOMContentLoaded.
function initHapusConfirm() {
  document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-hapus");
    if (!btn) return;
    const row = btn.closest("tr");
    const nama = row ? row.querySelector("td")?.textContent : "data ini";
    const yakin = confirm('Yakin ingin menghapus "' + nama + '"?');
    if (yakin && row) {
      row.remove();
    }
  });
}

// ===== Filter/pencarian tabel real-time =====
function initTableFilter() {
  const input = document.getElementById("search-input");
  const table =
    document.querySelector(".table-responsive table") ||
    document.querySelector("table");
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

// ===== Fungsi Generik Memuat Data Tabel (Jobsheet 8.4 Latihan No. 1) =====
async function muatTabelGenerik(urlJson, daftarKunci) {
  const tbody = document.querySelector(".table-responsive table tbody");
  const loading = document.getElementById("loading-indicator");
  if (!tbody) return;

  if (loading) {
    loading.style.display = "block";
  }

  tbody.innerHTML = "";

  try {
    // Delay 3 detik sesuai Latihan No. 3
    await new Promise((resolve) => setTimeout(resolve, 3000));

    const res = await fetch(urlJson);
    if (!res.ok) {
      throw new Error("Gagal mengambil data (status " + res.status + ")");
    }
    const dataList = await res.json();

    dataList.forEach(function (item) {
      const tr = document.createElement("tr");
      let htmlKolom = "";

      // Loop daftar kunci properti JSON
      daftarKunci.forEach(function (kunci) {
        htmlKolom += "<td>" + (item[kunci] !== undefined ? item[kunci] : "-") + "</td>";
      });

      htmlKolom +=
        "<td>" +
        '<button type="button" class="btn-edit">Edit</button> ' +
        '<button type="button" class="btn-detail">Detail</button> ' +
        '<button type="button" class="btn-hapus">Hapus</button>' +
        "</td>";

      tr.innerHTML = htmlKolom;
      tbody.appendChild(tr);
    });
  } catch (err) {
    tbody.innerHTML =
      '<tr><td colspan="6">Gagal memuat data: ' + err.message + "</td></tr>";
  } finally {
    if (loading) {
      loading.style.display = "none";
    }
  }
}
