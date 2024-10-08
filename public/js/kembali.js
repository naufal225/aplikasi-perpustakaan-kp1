$('.kondisi').on('change', function() {
    var kondisi = $(this).val(); // Nilai kondisi
    var row = $(this).closest('tr'); // Ambil row yang terkait
    var hargaBuku = row.data('harga-buku'); // Ambil harga buku dari data attribute
    var dendaHilangRusak = row.find('td:last'); // Kolom denda terakhir

    if (kondisi === 'hilang atau rusak') {
        // Set nilai denda ke harga buku
        dendaHilangRusak.text(hargaBuku);
    } else {
        // Jika baik, set denda ke 0
        dendaHilangRusak.text(0);
    }
});