<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';
    protected $guarded = [];

    public function roleKaryawan()
    {
        if ($this->role == 1) {
            return 'Admin';
        } elseif ($this->role == 2) {
            return 'Sopir';
        }
        return 'Kuli';
    }
}
