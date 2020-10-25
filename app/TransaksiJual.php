<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TransaksiJual extends Model
{
    protected $table = 'transaksi_jual';
    protected $guarded = [];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function total()
    {
        return $this->harga * $this->qty;
    }

    public function formatTanggal()
    {
        $time = strtotime($this->tanggal_input);
        $newformat = date('d-m-Y', $time);
        return $newformat;
    }
}
