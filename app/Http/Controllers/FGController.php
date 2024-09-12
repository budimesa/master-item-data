<?php

namespace App\Http\Controllers;

use App\Models\FinishedGood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FGController extends Controller
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
        $data = FinishedGood::orderBy($sortBy, $sortDirection)->paginate($perPage, ['*'], 'page', $currentPage);

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
