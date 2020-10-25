<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiBeli extends Model
{
    protected $table = 'transaksi_beli';
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
        // return $this->created_at->format('d-m-Y');
    }
}
