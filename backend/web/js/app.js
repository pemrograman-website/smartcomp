$(document).ready(function () {
  const $tambahAksesoris = $('.btn-tambah-aksesoris');
  const $pilihJenis = $('#jenis');
  const $pilihMerk = $('#merk');
  const $resetAksesoris = $('.btn-reset-aksesoris');
  RefreshHapusAksesorisListener(); // DI-REFRESH LISTENER NYA SETIAP KALI DOKUMEN DI-LOAD

  // Untuk menyimpan jumlah aksesoris yang dibeli dalam satu invoice.
  // Jika nilainya 0 maka invoice tidak dapat diproses.
  var jmlAksesoris = 0;

  $pilihJenis.change((ev) => {
    ev.preventDefault();
    const $this = $(ev.target);
    const jenisId = $pilihJenis.val();
    const merkId = $pilihMerk.val();
    $.ajax({
      method: 'POST',
      url: $this.attr('href'),
      data: { jenisId, merkId },
      success: function (result) {
        $('#list-aksesoris').html(result);
      },
    });
  });

  $pilihMerk.change((ev) => {
    ev.preventDefault();
    const $this = $(ev.target);
    const jenisId = $('#jenis').val();
    const merkId = $('#merk').val();
    $.ajax({
      method: 'POST',
      url: $this.attr('href'),
      data: { jenisId, merkId },
      success: function (result) {
        $('#list-aksesoris').html(result);
      },
    });
  });

  $tambahAksesoris.click((ev) => {
    ev.preventDefault();
    const $this = $(ev.target);
    const aksesorisId = $('#aksesoris').val();
    const jumlah = $('#jumlah').val();
    const harga = $('#harga').val();
    // console.log(aksesorisId, jumlah, harga, $this.attr('href'));

    if (aksesorisId == undefined || aksesorisId == '0') {
      alert('Silahkan pilih barangnya dulu.');
    } else if (harga == undefined || harga == '0') {
      alert('Silahkan harga barang diisi dulu.');
    } else {
      $.ajax({
        method: 'POST',
        url: $this.attr('href'),
        data: { aksesorisId, jumlah, harga },
        success: function (result) {
          $('#jumlah').val(1);
          $('#harga').val(0);
          jmlAksesoris = JSON.parse(result).jmlAksesoris;
          $('#daftar-pembelian').html(JSON.parse(result).hasilAjax);
          RefreshHapusAksesorisListener(); // DI-REFRESH LISTENER NYA SETIAP KALI BUTTON ADA YANG DITAMBAH
        },
      });
    }
  });

  $resetAksesoris.click((ev) => {
    ev.preventDefault();
    const $this = $(ev.target);
    var cek = confirm('Anda yakin mau menghapus daftar pembelian aksesoris?');
    if (cek) {
      $.ajax({
        method: 'POST',
        url: $this.attr('href'),
        data: {},
        success: function (result) {
          jmlAksesoris = 0; // Jumlah item aksesoris di nol kan, karena semua item aksesoris dihapus
          $('#daftar-pembelian').html(result);
        },
      });
    }

    return false;
  });

  $('#pembelian-aksesoris-form').submit(function () {
    if (jmlAksesoris == 0) {
      alert('Aksesoris yang akan dibeli belum dimasukkan');
      return false;
    } else {
      return true;
    }
  });

  /*
  IMPORTANT!!!! SEHARIAN NGOPREK BAGIAN INI....................

  Button hapus aksesoris akan muncul secara dinamis. Sehingga ketika Button hapus aksesoris tersebut
  bertambah atau berkurang, maka harus di-refresh listenernya. Fungsi ini bertujuan untuk me-refresh setiap
  kali button hapus aksesoris bertambah atau berkurang.
  */
  function RefreshHapusAksesorisListener() {
    $hapusAksesoris = $('a.btn-hapus-aksesoris');
    $hapusAksesoris.off();

    $hapusAksesoris.click((ev) => {
      ev.preventDefault();
      const $this = $(ev.target);
      // console.log('dieksekusi');

      var aksesorisId = $this.closest('.btn-hapus-aksesoris').attr('barang-id');
      // console.log(aksesorisId);
      var cek = confirm('Anda yakin mau menghapus aksesoris ini?');
      if (cek) {
        $.ajax({
          method: 'POST',
          url: $this.attr('url'),
          data: { aksesorisId },
          success: function (result) {
            jmlAksesoris = JSON.parse(result).jmlAksesoris;
            $('#daftar-pembelian').html(JSON.parse(result).hasilAjax);
            RefreshHapusAksesorisListener(); // DI-REFRESH BUTTON NYA SETIAP KALI BUTTON ADA YANG DIHILANGKAN
          },
        });
      }
      return false;
    });
  }
});
