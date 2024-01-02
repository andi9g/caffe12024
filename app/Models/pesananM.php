<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pesananM extends Model
{
    use HasFactory;
    protected $table = "pesanan";
    protected $primaryKey = "idpesanan";
    protected $guarded = [];

    public function list()
    {
        return $this->hasOne(listM::class, "idlist", "idlist");
    }

    public function meja()
    {
        return $this->hasOne(mejaM::class, "idmeja", "idmeja");
    }
}
