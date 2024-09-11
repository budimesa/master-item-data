<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WIPFinishedGood extends Model
{
    use HasFactory;

    protected $table = 'mst_wip_finished_goods';
    protected $guarded = [];
    // std_cost, qty_pack, std_wgt, size_code, unit_po, vend_proc, unit_stk, item_name, item_code, item_spec, brand_code, unit_pr, unit_prod,  series_type, unit_sales, phanton, unit_usg, color_code, density_code, level_code, created_by, created_at, updated_by, updated_at,  plus_minus_percentage, fixed_lot
    // SFG.P40ZUA<LGS
}
