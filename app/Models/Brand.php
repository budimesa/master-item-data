<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'mst_item_brand';
    protected $fillable = [
        'brand_name',
        'brand_code',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
}
