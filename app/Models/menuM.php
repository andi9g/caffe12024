<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menuM extends Model
{
    use HasFactory;
    protected $table = "menu";
    protected $primaryKey = "idmenu";
    protected $guarded = [];

    public function list()
    {
        return $this->hasOne(listM::class, "idmenu", "idmenu");
    }
}
