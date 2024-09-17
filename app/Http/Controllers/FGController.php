<?php

namespace App\Http\Controllers;

use App\Models\FinishedGood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FGController extends Controller
{
    public function index(Request $request)
    {
        $query = FinishedGood::query();

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
            'price_type' => 'nullable|string',
            'std_cost' => 'numeric',
            'qty_pack' => 'numeric',
            'std_wgt' => 'numeric',
            'size_code' => 'string',
            'unit_po' => 'string',
            'product_type' => 'nullable|string',
            'vend_proc' => 'nullable',
            'unit_stk' => 'string',
            'item_name' => 'required|string',
            'item_code' => 'string',
            'item_spec' => 'required|string',
            'brand_code' => 'string',
            'unit_pr' => 'string',            
            'item_order_code' => 'nullable',
            'color_tol_code' => 'nullable',
            'unit_prod' => 'string',
            'item_grade' => 'nullable|string',
            'series_type' => 'nullable|string',
            'unit_sales' => 'string',
            'phanton' => 'string',
            'unit_usg' => 'string',
            'business_type' => 'nullable',
            'color_code' => 'string',
            'density_code' => 'string',
            'busines_type' => 'nullable',
            'size_tol_code' => 'nullable',
            'level_code' => 'string',            
            'kw_1_xx_percentage' => 'numeric',            
        ]);

        $data['created_by'] = Auth::id(); // Ambil ID pengguna yang sedang login

        FinishedGood::create($data);

        return response()->json([
            'message' => 'FG created successfully!',
            'finishedGood' => $data,
        ]);
    }

    public function update(Request $request, FinishedGood $fg)
    {
        $data = $request->validate([
            'price_type' => 'nullable|string',
            'std_cost' => 'numeric',
            'qty_pack' => 'numeric',
            'std_wgt' => 'numeric',
            'size_code' => 'string',
            'unit_po' => 'string',
            'product_type' => 'nullable|string',
            'vend_proc' => 'nullable',
            'unit_stk' => 'string',
            'item_name' => 'required|string',
            'item_code' => 'string',
            'item_spec' => 'required|string',
            'brand_code' => 'string',
            'unit_pr' => 'string',            
            'item_order_code' => 'nullable',
            'color_tol_code' => 'nullable',
            'unit_prod' => 'string',
            'item_grade' => 'nullable|string',
            'series_type' => 'nullable|string',
            'unit_sales' => 'string',
            'phanton' => 'string',
            'unit_usg' => 'string',
            'business_type' => 'nullable',
            'color_code' => 'string',
            'density_code' => 'string',
            'busines_type' => 'nullable',
            'size_tol_code' => 'nullable',
            'level_code' => 'string',            
            'kw_1_xx_percentage' => 'numeric',
        ]);

        $data['updated_by'] = Auth::id(); // Ambil ID pengguna yang sedang login

        $fg->update($data);

        return response()->json([
            'message' => 'FG updated successfully!',
            'finishedGood' => $fg,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $fg = FinishedGood::findOrFail($id);
            $fg->delete();
    
            return response()->json(['message' => 'FG deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete FG.'], 500);
        }
    }
}
