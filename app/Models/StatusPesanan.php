<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPesanan extends Model
{
    use HasFactory;

    protected $table = "status_pesanan";
    protected $primaryKey = 'id';
    public $incrementing = false;
}
