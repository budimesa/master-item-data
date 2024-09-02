<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $table = 'mst_item_size';
    protected $fillable = [
        'fg_width',
        'fg_length',
        'size_name',
        'size_code',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
}
