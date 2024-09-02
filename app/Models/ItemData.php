<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemData extends Model
{
    use HasFactory;

    protected $table = 'mst_item_data_operating';
    protected $fillable = [
        'qty_safty',
        'safety_m',
        'dol_trade',
        'price_type',
        'std_cost',
        'qty_std_l',
        'durability',
        'qty_pack',
        'std_wgt',
        'size_code',
        'unit_po',
        'vend_proc',
        'unit_stk',
        'item_name',
        'item_code',
        'item_type',
        'item_spec',
        'brand_code',
        'unit_pr',
        'lead_time',
        'clr_tol_code',
        'unit_prod',
        'item_grade',
        'series_type',
        'unit_sales',
        'phanton',
        'unit_usg',
        'color_code',
        'density_code',
        'size_tol_code',
        'qty_min',
        'level_code',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'usage_to',
        'plus_minus_percentage',
        'standar_plus_minus',
        'kw_1_xx_percentage',
    ];
}
