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
}
