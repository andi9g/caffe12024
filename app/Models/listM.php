<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listM extends Model
{
    use HasFactory;
    protected $table = "list";
    protected $primaryKey = "idlist";
    protected $guarded = [];

    public function menu()
    {
        return $this->hasOne(menuM::class, "idmenu", "idmenu");
    }
}
