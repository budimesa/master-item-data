<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RawMaterialController extends Controller
{

    public function index(Request $request)
    {
        $query = RawMaterial::query();

        // Apply global filter
        if ($request->has('filters.global.value')) {
            $query->where('item_code', 'like', '%' . $request->input('filters.global.value') . '%')
                ->orWhere('item_name', 'like', '%' . $request->input('filters.global.value') . '%');
        }

        // Apply specific filters
        if ($request->has('filters.item_code.value')) {
            $query->where('item_code', 'like', $request->input('filters.item_code.value') . '%');
        }

        if ($request->has('filters.item_name.value')) {
            $query->where('item_name', 'like', $request->input('filters.item_name.value') . '%');
        }

        $query->orderBy('created_at', 'desc'); 
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $perPage;
        $results = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $results->items(),
            'total' => $results->total(),
            'per_page' => $results->perPage(),
            'current_page' => $results->currentPage(),
            'from' => $results->firstItem(),
            'last_page' => $results->lastPage(),
            'offset' => $offset
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
