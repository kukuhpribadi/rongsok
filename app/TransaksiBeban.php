<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiBeban extends Model
{
    protected $table = 'transaksi_beban';
    protected $guarded = [];

    public function beban_usaha()
    {
        return $this->belongsTo(BebanUsaha::class);
    }
}
