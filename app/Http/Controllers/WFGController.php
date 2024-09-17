<?php

namespace App\Http\Controllers;

use App\Models\WIPFinishedGood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WFGController extends Controller
{
    public function index(Request $request)
    {
        $query = WIPFinishedGood::query();

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

        // Pagination
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        $results = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $results->items(),
            'total' => $results->total(),
            'per_page' => $results->perPage(),
            'current_page' => $results->currentPage(),
            'from' => $results->firstItem(),
            'last_page' => $results->lastPage()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'std_cost' => 'numeric',
            'qty_pack' => 'numeric',
            'std_wgt' => 'numeric',
            'size_code' => 'string',
            'unit_po' => 'string',
            'vend_proc' => 'nullable',
            'unit_stk' => 'string',
            'item_name' => 'required|string',
            'item_code' => 'string',
            'item_spec' => 'required|string',
            'brand_code' => 'string',
            'unit_pr' => 'string',            
            'item_order_code' => 'nullable',
            'unit_prod' => 'string',
            'series_type' => 'nullable|string',
            'unit_sales' => 'string',
            'phanton' => 'string',
            'unit_usg' => 'string',
            'business_type' => 'nullable',
            'color_code' => 'string',
            'density_code' => 'string',
            'level_code' => 'string',            
            'plus_minus_percentage' => 'numeric',
            'fixed_lot' => 'numeric',
            
        ]);

        $data['created_by'] = Auth::id(); // Ambil ID pengguna yang sedang login

        WIPFinishedGood::create($data);

        return response()->json([
            'message' => 'WFG created successfully!',
            'wipFinishedGoods' => $data,
        ]);
    }

    public function update(Request $request, WIPFinishedGood $wfg)
    {
        $data = $request->validate([
            'std_cost' => 'numeric',
            'qty_pack' => 'numeric',
            'std_wgt' => 'numeric',
            'size_code' => 'string',
            'unit_po' => 'string',
            'vend_proc' => 'nullable',
            'unit_stk' => 'string',
            'item_name' => 'required|string',
            'item_code' => 'string',
            'item_spec' => 'required|string',
            'brand_code' => 'string',
            'unit_pr' => 'string',            
            'item_order_code' => 'nullable',
            'unit_prod' => 'string',
            'series_type' => 'nullable|string',
            'unit_sales' => 'string',
            'phanton' => 'string',
            'unit_usg' => 'string',
            'business_type' => 'nullable',
            'color_code' => 'string',
            'density_code' => 'string',
            'level_code' => 'string',            
            'plus_minus_percentage' => 'numeric',
            'fixed_lot' => 'numeric',
        ]);

        $data['updated_by'] = Auth::id(); // Ambil ID pengguna yang sedang login

        $wfg->update($data);

        return response()->json([
            'message' => 'WFG updated successfully!',
            'wipFinishedGoods' => $wfg,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $wfg = WIPFinishedGood::findOrFail($id);
            $wfg->delete();
    
            return response()->json(['message' => 'WFG deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete WFG.'], 500);
        }
    }
}
