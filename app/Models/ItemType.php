<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    use HasFactory;

    protected $table = 'mst_item_type';
    protected $fillable = [
        'type_name',
        'type_code',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
}
