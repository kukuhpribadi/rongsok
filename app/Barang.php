<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $guarded = [];

    public function transaksi_beli()
    {
        return $this->hasMany(TransaksiBeli::class);
    }

    public function transaksi_jual()
    {
        return $this->hasMany(TransaksiJual::class);
    }
}
