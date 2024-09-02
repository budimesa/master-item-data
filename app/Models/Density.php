<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Density extends Model
{
    use HasFactory;

    protected $table = 'mst_item_density';
    protected $fillable = [
        'density_name',
        'density_code',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
}
