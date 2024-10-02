<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Peminjaman</title>
</head>
<body>
    <h1>{{ $nama_perpustakaan }}</h1>
    <p>{{ $alamat_perpustakaan }}</p>
    <hr>
    <p><strong>Tanggal & Waktu:</strong> {{ $tanggal_jam }}</p>
    <p><strong>Kode Transaksi:</strong> {{ $kode_transaksi }}</p>
    <p><strong>Nama Member:</strong> {{ $nama_member }}</p>
    <h3>Daftar Buku yang Dipinjam:</h3>
    <ul>
        @foreach ($daftar_buku as $judul_buku)
            <li>{{ $judul_buku }}</li>
        @endforeach
    </ul>
</body>
</html>
