<?php

namespace App\Http\Controllers;

use App\Models\SizeTol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class SizeTolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sizeTols = SizeTol::all();
        return response()->json(['sizeTols' => $sizeTols]);
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
            'size_tol_name' => 'required|string|max:255',
            'size_tol_code' => 'required|string',
        ]);

        $data = $request->only('size_tol_name', 'size_tol_code');
        $data['created_by'] = Auth::id(); // Ambil ID pengguna yang sedang login
    
        SizeTol::create($data);

        return response()->json([
            'message' => 'SizeTol created successfully!',
            'sizeTol' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SizeTol $sizeTol)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SizeTol $sizeTol)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SizeTol $sizeTol)
    {
        $request->validate([
            'size_tol_name' => 'required|string|max:255',
            'size_tol_code' => 'required|string',
        ]);

        $data = $request->only('size_tol_name', 'size_tol_code');
        $data['updated_by'] = Auth::id(); // Ambil ID pengguna yang sedang login
    
        $sizeTol->update($data);

        return response()->json([
            'message' => 'SizeTol updated successfully!',
            'sizeTol' => $data,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $sizeTol = SizeTol::findOrFail($id);
            $sizeTol->delete();
    
            return response()->json(['message' => 'Size Tol deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete brand.'], 500);
        }
    }
}
