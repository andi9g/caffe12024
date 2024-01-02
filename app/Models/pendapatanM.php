<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pendapatanM extends Model
{
    use HasFactory;
    protected $table = "pendapatan";
    protected $primaryKey = "idpendapatan";
    protected $guarded = [];

    public function list()
    {
        return $this->hasOne(listM::class, "idlist", "idlist");
    }
}
