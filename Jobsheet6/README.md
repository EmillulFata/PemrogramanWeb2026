1. Satukan buku.js dan anggota.js jadi satu fungsi generik yang menerima nama file JSON dan daftar 
   nama kunci sebagai parameter,latihan langsung untuk pertanyaan yang diajukan di bab 5 §5.4.
2. Tambah kolom baru di data/buku.json (misalnya "kategori"), lalu tampilkan di tabel dengan 
   menambah satu <th> di HTML dan satu <td> di tr.innerHTML pada buku.js. 
3. Ganti delay simulasi di bab 4 §4.4 dari 600 menjadi 3000 (3 detik), amati loading indicator jadi jauh lebih 
   terlihat,ini juga cara yang baik untuk merasakan pentingnya loading indicator pada koneksi yang lambat. 

Jawab :
1. async function muatTabelGenerik(urlJson, daftarKunci) {
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

buku.js
document.addEventListener("DOMContentLoaded", function () {
  muatTabelGenerik("../data/buku.json", [
    "judul",
    "pengarang",
    "tahun",
    "stok",
    // penambahan "kategori"
    "kategori",
  ]);
});

anggota.js
document.addEventListener("DOMContentLoaded", function () {
  muatTabelGenerik("../data/anggota.json", [
    "no_anggota",
    "nama",
    "alamat",
    "no_hp",
    "tanggal_bergabung",
  ]);
});

2. {
    "judul": "Laskar Pelangi",
    "pengarang": "Andrea Hirata",
    "tahun": 2005,
    "stok": 4,
    "kategori": "Fiksi"
  },

  3. await new Promise((resolve) => setTimeout(resolve, 3000));

