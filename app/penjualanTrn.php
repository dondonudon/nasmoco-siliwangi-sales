<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class penjualanTrn extends Model
{
    protected $table = 'penjualan_trn';
    protected $fillable = ['no_spk','id_area','username'];
}
