<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return response()->json(['brands' => $brands]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'brand_code' => 'required|string',
        ]);

        // Brand::create($request->only('brand_name', 'brand_code'));
        $data = $request->only('brand_name', 'brand_code');
        $data['created_by'] = Auth::id(); // Ambil ID pengguna yang sedang login
    
        Brand::create($data);

        return response()->json([
            'message' => 'Brand created successfully!',
            'brand' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'brand_code' => 'required|string',
        ]);
    
        $data = $request->only('brand_name', 'brand_code');
        $data['updated_by'] = Auth::id();

        $brand->update($data);
    
        return response()->json([
            'message' => 'Brand updated successfully!',
            'brand' => $brand,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->delete();
    
            return response()->json(['message' => 'Brand deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete brand.'], 500);
        }
    }
}
