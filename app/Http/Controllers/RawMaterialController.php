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

        // Mendapatkan parameter sort_by dan sort_direction dari request
        $sortBy = $request->input('sort_by', 'id'); // Default sort by 'id'
        $sortDirection = $request->input('sort_direction', 'desc'); // Default sort direction 'desc'

        // Validasi nilai sort_direction
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc'; // Atur default jika nilai tidak valid
        }

        // Mendapatkan data dengan pagination dan pengurutan
        $data = RawMaterial::orderBy($sortBy, $sortDirection)->paginate($perPage, ['*'], 'page', $currentPage);

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
            'vend_proc' => 'nullable',
            'unit_stk' => 'string',
            'item_name' => 'required|string',
            'item_code' => 'string',
            'item_spec' => 'required|string',
            'unit_pr' => 'string',
            'item_order_code' => 'nullable',
            'lead_time' => 'numeric',
            'unit_prod' => 'string',
            'series_type' => 'nullable|string',
            'unit_sales' => 'string',
            'phanton' => 'string',
            'unit_usg' => 'string',
            'business_type' => 'nullable',
            'qty_min' => 'numeric',
            'level_code' => 'string',
            'created_by' => 'string',
            'updated_by' => 'string',
            'usage_to' => 'nullable',
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
            'qty_safety' => 'numeric',
            'safety_m' => 'numeric',
            'std_cost' => 'numeric',
            'durability' => 'numeric',
            'unit_po' => 'string',
            'vend_proc' => 'nullable',
            'unit_stk' => 'string',
            'item_name' => 'required|string',
            'item_code' => 'string',
            'item_spec' => 'required|string',
            'unit_pr' => 'string',
            'lead_time' => 'numeric',
            'unit_prod' => 'string',
            'series_type' => 'nullable|string',
            'unit_sales' => 'string',
            'phanton' => 'string',
            'unit_usg' => 'string',
            'qty_min' => 'numeric',
            'level_code' => 'string',
            'created_by' => 'string',
            'usage_to' => 'nullable',
            'plus_minus_percentage' => 'numeric',
            'standar_plus_minus' => 'numeric',
            'fixed_lot' => 'numeric',
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
