<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemiFinishedGood extends Model
{
    use HasFactory;
    protected $table = 'mst_wip_finished_goods';
    protected $guarded = [];
}
