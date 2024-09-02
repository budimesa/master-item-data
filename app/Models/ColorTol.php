<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorTol extends Model
{
    use HasFactory;

    protected $table = 'mst_item_color_tol';
    protected $fillable = [
        'color_tol_name',
        'color_tol_code',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
}
