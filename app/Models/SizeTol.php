<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SizeTol extends Model
{
    use HasFactory;

    protected $table = 'mst_item_size_tol';
    protected $fillable = [
        'size_tol_name',
        'size_tol_code',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
}
