<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RawMaterialController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Default 10
        $currentPage = $request->input('page', 1); // Default 1

        // Mendapatkan data dengan pagination
        $data = RawMaterial::paginate($perPage, ['*'], 'page', $currentPage);

        return response()->json([
            'data' => $data->items(),
            'total' => $data->total(),
            'per_page' => $data->perPage(),
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'from' => $data->firstItem(),
            'to' => $data->lastItem()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'qty_safety' => 'numeric',
            'safety_m' => 'numeric',
            'std_cost' => 'numeric',
            'durability' => 'numeric',
            'unit_po' => 'string',
            'vend_proc' => 'string',
            'unit_stk' => 'string',
            'item_name' => 'required|string',
            'item_code' => 'string',
            'item_spec' => 'required|string',
            'unit_pr' => 'string',
            'lead_time' => 'numeric',
            'unit_prod' => 'string',
            'series_type' => 'string',
            'unit_sales' => 'string',
            'phanton' => 'string',
            'unit_usg' => 'string',
            'qty_min' => 'numeric',
            'level_code' => 'string',
            'created_by' => 'string',
            'updated_by' => 'string',
            'usage_to' => 'string',
            'plus_minus_percentage' => 'numeric',
            'standar_plus_minus' => 'numeric',
            'fixed_lot' => 'numeric',
            
        ]);

        $data['created_by'] = Auth::id(); // Ambil ID pengguna yang sedang login

        RawMaterial::create($data);

        return response()->json([
            'message' => 'Item Data created successfully!',
            'rawMaterials' => $data,
        ]);
    }

    public function update(Request $request, RawMaterial $rawMaterial)
    {
        $data = $request->validate([
            'qty_safety' => 'required|numeric',
            'safety_m' => 'required|numeric',
            'std_cost' => 'required|numeric',
            'qty_std_l' => 'required|numeric',
            'durability' => 'required|numeric',
            'qty_pack' => 'required|numeric',
            'std_wgt' => 'required|numeric',
            'size_code' => 'required|string',
            'unit_po' => 'required|string',
            'vend_proc' => 'required|string',
            'unit_stk' => 'required|string',
            'item_name' => 'required|string',
            'item_code' => 'required|string',
            'item_type' => 'required|string',
            'item_spec' => 'required|string',
            'brand_code' => 'required|string',
            'unit_pr' => 'required|string',
            'lead_time' => 'required|numeric',
            'clr_tol_code' => 'required|string',
            'unit_prod' => 'required|string',   
            'item_grade' => 'required|string',
            'series_type' => 'required|string',
            'unit_sales' => 'required|string',
            'phanton' => 'required|string',
            'unit_usg' => 'required|string',
            'color_code' => 'required|string',
            'density_code' => 'required|string',
            'size_tol_code' => 'required|string',
            'qty_min' => 'required|numeric',
            'level_code' => 'required|string',
            'created_by' => 'required|string',
            'updated_by' => 'required|string',
            'usage_to' => 'required|string',
            'plus_minus_percentage' => 'required|numeric',
            'standar_plus_minus' => 'required|numeric',
            'kw_1_xx_percentage' => 'required|numeric',
        ]);

        $data['updated_by'] = Auth::id(); // Ambil ID pengguna yang sedang login

        $rawMaterial->update($data);

        return response()->json([
            'message' => 'Item Data updated successfully!',
            'rawMaterials' => $rawMaterial,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $rawMaterial = RawMaterial::findOrFail($id);
            $rawMaterial->delete();
    
            return response()->json(['message' => 'Item Data deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete brand.'], 500);
        }
    }
}
