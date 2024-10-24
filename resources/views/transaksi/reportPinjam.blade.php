<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Peminjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            counter-reset: page;
        }
        @media print {
            @page {
                margin: 100px 20px; /* Set margin for the printed page */
            }
            .header, .footer {
                position: fixed;
                left: 0;
                right: 0;
                height: 50px;
                font-size: 10px;
                padding-top: 10px;
            }
            .header {
                top: 0; /* Place header at the top */
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .header img {
                max-width: 100px; /* Ukuran logo */
            }
            .info {
                text-align: left;
                padding-right: 20px;
            }
            .address {
                font-size: 10px;
            }
            .footer {
                position: fixed;
                bottom: 0; /* Place footer at the bottom */
                border-top: 1px solid #000;
            }
            .footer .page-number:before {
                content: "Halaman " counter(page) " dari " attr(data-total-pages);
            }
            .page {
                page-break-after: always;
                page-break-inside: avoid;
                margin-top: 120px; /* Tambah jarak agar tidak menimpa header */
            }
        }
        .footer {
            position: fixed;
            bottom: 0; /* Place footer at the bottom */
            left: 0;
            right: 0;
            border-top: 1px solid #000;
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
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header img {
            float: left;
            width: 120px;
        }
        .info {
            text-align: center;
        }
        .address {
            font-size: 10px;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }
        .page-break {
            page-break-after: always;
        }
        .clearfix::after {
          content: "";
          clear: both;
          display: table;
        }
    </style>
</head>
<body>

    
    @foreach ($transaksi->chunk(15) as $chunk)
    <div class="header">
        <img src="data:image/{{ pathinfo(public_path('img/logoperpus.png'), PATHINFO_EXTENSION) }};base64,{{ base64_encode(file_get_contents(public_path('img/logoperpus.png'))) }}" alt="Logo Perpustakaan">
        <div class="info">
            <h2 style="font-size: 23px;margin-top: 0px;">{{ $nama_perpustakaan }}</h2>
            <p class="address" style="font-size: 13px;">{{ $alamat_perpustakaan }}</p>
        </div>
    </div>
    
    <hr>
    <table>
        <tr>
            <td class="no-border"><strong>Tanggal & Waktu:</strong></td>
            <td class="no-border">{{ $tanggal_jam }}</td>
        </tr>
        <tr>
            <td class="no-border"><strong>Nama Pustakawan:</strong></td>
            <td class="no-border">{{ $pustakawan }}</td>
        </tr>
    </table>
        <div class="page"> <!-- Start a new page for each chunk -->
            <h3 style="text-align: center">LAPORAN REKAPITULASI PEMINJAMAN BUKU</h3>
            <table>
                <thead>
                    <tr>
                        <th style="text-align: center">No</th>
                        <th style="text-align: center">Kode Peminjaman</th>
                        <th style="text-align: center">Kode Member</th>
                        <th style="text-align: center">Kode Buku</th>
                        <th style="text-align: center">Tanggal Pinjam</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($chunk as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($loop->parent->iteration - 1) * 15 }}</td>
                            <td>{{ $item->kode_peminjaman }}</td>
                            <td>{{ $item->member->kode_member }}</td>
                            <td>{{ $item->buku->kode_buku }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_peminjaman)->format('d-m-Y H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Check if this is the last chunk to display signatures -->
            @if ($loop->last)
        <p style="text-align: right; margin-right: 73px">Mengetahui,</p>
            <div class="signature" style="text-align:center">
                <div style="float: left;margin-left:2cm">
                    <p>Kepala Pustakawan</p>
                    <br><br><br>
                    <p>(Naufal Ma'ruf Ashrori)</p>
                </div>
                <div style="margin-left: 8cm;">
                    <p>Pustakawan</p>
                    <br><br><br>
                    <p>({{ Auth::user()->nama_lengkap }})</p>
                </div>
            </div>
        @endif

            <div class="clearfix"></div>

            <div class="footer">
                <p style="float: left;">Divisi Administrasi Perpustakaan</p>
                <p style="text-align: right">Halaman ke {{ $loop->iteration }} dari {{ isset($chunksCount) ? $chunksCount : 15 }}</p> <!-- Update the footer -->
            </div>

            @if (!$loop->last)
                <div class="page-break"></div>
            @endif
        </div>
    @endforeach

</body>
</html>
