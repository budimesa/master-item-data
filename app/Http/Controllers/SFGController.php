<?php

namespace App\Http\Controllers;

use App\Models\SemiFinishedGood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SFGController extends Controller
{
    public function index(Request $request)
    {
        $query = SemiFinishedGood::query();

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
        ]);

        $data['created_by'] = Auth::id(); // Ambil ID pengguna yang sedang login

        SemiFinishedGood::create($data);

        return response()->json([
            'message' => 'SFG created successfully!',
            'semiFinishedGood' => $data,
        ]);
    }

    public function update(Request $request, SemiFinishedGood $sfg)
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
        ]);

        $data['updated_by'] = Auth::id(); // Ambil ID pengguna yang sedang login

        $sfg->update($data);

        return response()->json([
            'message' => 'SFG updated successfully!',
            'semiFinishedGood' => $sfg,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $sfg = SemiFinishedGood::findOrFail($id);
            $sfg->delete();
    
            return response()->json(['message' => 'SFG deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete SFG.'], 500);
        }
    }
}
