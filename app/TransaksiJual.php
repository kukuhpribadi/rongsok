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
        return $this->created_at->format('d-m-Y');
    }
}
