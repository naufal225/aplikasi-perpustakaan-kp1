<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Peminjaman Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Laporan Pengembalian Buku</h1>
    <p>Tanggal: {{ $tanggal_jam }}</p>

    <table>
        <thead>
            <th>No</th>
            <th>Kode Peminjaman</th>
            <th>Nama Peminjam</th>
            <th>Judul Buku</th>
            <th>Tanggal</th>
        </thead>
        <tbody>
            @foreach($data as $i)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $i->kode_pengembalian }}</td>
                <td>{{ $i->transaksi_pinjam->member->nama_lengkap }}</td>
                <td>{{ $i->buku->judul_buku }}</td>
                <td>{{ $i->tgl_pengembalian }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>