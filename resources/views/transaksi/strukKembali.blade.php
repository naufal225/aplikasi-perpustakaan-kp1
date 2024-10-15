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
            text-align: center;
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
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $nama_perpustakaan }}</h1>
        <p>{{ $alamat_perpustakaan }}</p>
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
