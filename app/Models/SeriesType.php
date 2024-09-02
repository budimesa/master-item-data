<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeriesType extends Model
{
    use HasFactory;
    
    protected $table = 'mst_item_series_type';
    protected $fillable = [
        'series_type_name',
        'series_type_code',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
}
