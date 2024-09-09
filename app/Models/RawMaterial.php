<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    use HasFactory;

    protected $table = 'mst_raw_materials';
    protected $guarded = [];
    // raw material level code N
    // WFG S
    // SFG M
    // FG Y
}
