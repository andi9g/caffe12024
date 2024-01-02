<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mejaM extends Model
{
    use HasFactory;
    protected $table = "meja";
    protected $primaryKey = "idmeja";
    protected $guarded = [];

}
