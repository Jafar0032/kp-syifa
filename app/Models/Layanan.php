<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;
    protected $table = "layanan";

    public function harga_layanan() {
        return $this->hasMany(HargaLayanan::class,'id','id_layanan');
    }
}
