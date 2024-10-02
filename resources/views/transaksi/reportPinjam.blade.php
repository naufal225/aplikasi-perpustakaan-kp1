<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman Buku</title>
    <style>
        @page {
            margin: 1cm;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding-top: 4cm; /* Menambah jarak dari atas halaman */
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            text-align: center;
            line-height: 1.5cm;
            font-size: 12px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2cm;
            text-align: center;
            line-height: 1.5cm;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1cm; /* Memberikan jarak antara tabel dan header */
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2; /* Warna latar belakang untuk header */
        }

        .ttd > table > th, td {
            border: none;
        }

        .page-number::before {
            content: counter(page);
        }

        .total-pages::before {
            content: "1"; /* Default value */
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Perpustakaan XYZ</h2>
        <p>Pustakawan: {{ $pustakawan }}</p>
        <p>Alamat: Jl. Contoh No. 123, Kota X</p>
        <hr>
    </div>

    <h3 style="text-align: center;">Laporan Rekapitulasi Peminjaman Buku</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Peminjaman</th>
                <th>Nama Peminjam</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kode_peminjaman }}</td>
                    <td>{{ $item->member->nama_lengkap }}</td>
                    <td>{{ $item->buku->judul_buku }}</td>
                    <td>{{ $item->tgl_peminjaman }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="ttd" style="margin-top: 2cm;">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="text-align: center;">Kepala Pustakawan</td>
                <td style="text-align: center;">Pustakawan</td>
            </tr>
            <tr>
                <td style="height: 80px;"></td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: center;">(...................................)</td>
                <td style="text-align: center;">(...................................)</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <hr>
        <table style="width: 100%; border: none">
            <tr>
                <td style="text-align: left; border: none;">Divisi Administrasi</td>
                <td style="text-align: right; border: none;">
                    Halaman <span class="page-number"></span> dari <span class="total-pages"></span>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
