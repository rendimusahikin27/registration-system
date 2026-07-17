document.addEventListener("DOMContentLoaded", function () {
  var form = document.getElementById("daftarForm");
  var status = document.getElementById("formStatus");
  var submitBtn = form.querySelector(".btn-submit");
  var btnText = form.querySelector(".btn-text");

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    var nama = form.nama.value.trim();
    var email = form.email.value.trim();
    var whatsapp = form.whatsapp.value.trim();
    var acara = form.acara.value;

    if (!nama || !email || !whatsapp || !acara) {
      showStatus("Semua kolom wajib diisi kecuali catatan.", "err");
      return;
    }

    var payload = new FormData(form);

    submitBtn.disabled = true;
    btnText.textContent = "Mengirim...";
    showStatus("", "");

    fetch("register.php", {
      method: "POST",
      body: payload,
      headers: { "X-Requested-With": "XMLHttpRequest" },
    })
      .then(function (res) {
        return res.json();
      })
      .then(function (data) {
        if (data) {
          showStatus(
            "Pendaftaran berhasil! Konfirmasi akan dikirim lewat WhatsApp.",
            "ok",
          );
          form.reset();
        } else {
          showStatus(data.message || "Terjadi kesalahan, coba lagi.", "err");
        }
      })
      .catch(function () {
        showStatus(
          "Gagal terhubung ke server. Periksa koneksi lalu coba lagi.",
          "err",
        );
      })
      .finally(function () {
        submitBtn.disabled = false;
        btnText.textContent = "Daftar Sekarang";
      });
  });

  function showStatus(message, kind) {
    status.textContent = message;
    status.className = "form-status" + (kind ? " " + kind : "");
  }
});
