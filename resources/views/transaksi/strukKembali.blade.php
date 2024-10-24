<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pengembalian</title>
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
    width: 120px;
    height: auto;
    display: block;
    margin: 0 auto;
}
.info {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="data:image/{{ pathinfo(public_path('img/logoperpus.png'), PATHINFO_EXTENSION) }};base64,{{ base64_encode(file_get_contents(public_path('img/logoperpus.png'))) }}" alt="Logo Perpustakaan" style="float: left">
        <div class="info">
            <h2 style="font-size: 23px;margin-top: 0px;">{{ $nama_perpustakaan }}</h2>
            <p class="address" style="font-size: 13px;">{{ $alamat_perpustakaan }}</p>
        </div>
    </div>
    <hr>
    <table>
        <tr>
            <td class="no-border"><strong>Tanggal & Waktu Pengembalian:</strong></td>
            <td class="no-border">{{ now()->format('d-m-Y H:m:s') }}</td>
        </tr>
        <tr>
            <td class="no-border"><strong>Tanggal & Waktu Peminjaman:</strong></td>
            <td class="no-border">{{ $transaksi_data[0]['tgl_peminjaman'] }}</td>
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

    <h3>Daftar Buku yang Dikembalikan:</h3>
    <table>
        <thead>
            <tr>
                <th style="text-align: center">No</th>
                <th style="text-align: center">Judul Buku</th>
                <th style="text-align: center">Kondisi Buku</th>
                <th style="text-align: center">Status</th>
                <th style="text-align: center">Denda Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi_data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['judul_buku'] }}</td>
                <td>{{ $item['kondisi'] }}</td>
                <td>{{ $item['status'] }}</td>
                <td>Rp. {{ $item['denda_total'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Terima Kasih</strong></p>
    </div>
</body>
</html>
