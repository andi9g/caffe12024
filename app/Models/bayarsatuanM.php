<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bayarsatuanM extends Model
{
    use HasFactory;
    protected $table = "bayarsatuan";
    protected $primaryKey = "idbayarsatuan";
    protected $guarded = [];

    public function list()
    {
        return $this->hasOne(listM::class, "idlist", "idlist");
    }
}
