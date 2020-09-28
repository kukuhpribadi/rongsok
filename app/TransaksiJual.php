<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiJual extends Model
{
    protected $table = 'transaksi_jual';
    protected $guarded = [];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
