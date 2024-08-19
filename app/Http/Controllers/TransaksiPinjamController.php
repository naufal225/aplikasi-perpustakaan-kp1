<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPinjam;
use Illuminate\Http\Request;

class TransaksiPinjamController extends Controller
{
    public function updateStatus() {
        $transaksi = TransaksiPinjam::all();
        $today = now()->toDateString();

        foreach($transaksi as $row) {
            if($row->estimasi_tgl_kembali < $today && $row->keterangan != "selesai") {
                $row->status = "telat";
                $row->save();
            }
        }
    }
}
