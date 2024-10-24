<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Peminjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        h1, h3 {
            text-align: center;
        }
        p {
            margin: 5px 0;
        }
        hr {
            margin: 20px 0;
        }
        .header {
        top: -20px; /* Adjust this value to move the header upwards */
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .header img {
        max-width: 150px; /* Ukuran logo */
        margin-top: -30px; /* Adjust this value to move the image upwards */
    }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .no-border {
            border: none;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
        }
        img {
    width: auto;
    height: 120px;
}   
.info {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="data:image/{{ pathinfo(public_path('img/logoperpus.png'), PATHINFO_EXTENSION) }};base64,{{ base64_encode(file_get_contents(public_path('img/logoperpus.png'))) }}" alt="Logo Perpustakaan" style="float: left;">
        <div class="info">
            <h2 style="font-size: 23px;margin-top: 0px;">{{ $nama_perpustakaan }}</h2>
            <p class="address" style="font-size: 13px;">{{ $alamat_perpustakaan }}</p>
        </div>
    </div>
    <hr>
    <table>
        <tr>
            <td class="no-border"><strong>Tanggal & Waktu:</strong></td>
            <td class="no-border">{{ now()->format('d-m-Y H:m:s') }}</td>
        </tr>
        <tr>
            <td class="no-border"><strong>Kode Transaksi:</strong></td>
            <td class="no-border">{{ $kode_transaksi }}</td>
        </tr>
        <tr>
            <td class="no-border"><strong>Nama Member:</strong></td>
            <td class="no-border">{{ $nama_member }}</td>
        </tr>
    </table>

    <h3>Daftar Buku yang Dipinjam:</h3>
    <table>
        <thead>
            <tr>
                <th style="text-align: center">No</th>
                <th style="text-align: center">Judul Buku</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($daftar_buku as $index => $judul_buku)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $judul_buku }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Terima Kasih</strong></p>
    </div>
</body>
</html>
