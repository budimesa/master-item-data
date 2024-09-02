<?php

namespace App\Http\Controllers;

use App\Models\ColorTol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColorTolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colorTols = ColorTol::all();
        return response()->json(['colorTols' => $colorTols]);
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
            'color_tol_name' => 'required|string|max:255',
            'color_tol_code' => 'required|string',
        ]);

        $data = $request->only('color_tol_name', 'color_tol_code');
        $data['created_by'] = Auth::id(); // Ambil ID pengguna yang sedang login
    
        ColorTol::create($data);

        return response()->json([
            'message' => 'Color Tol created successfully!',
            'colorTol' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ColorTol $colorTol)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ColorTol $colorTol)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ColorTol $colorTol)
    {
        $request->validate([
            'color_tol_name' => 'required|string|max:255',
            'color_tol_code' => 'required|string',
        ]);

        $data = $request->only('color_tol_name', 'color_tol_code');
        $data['updated_by'] = Auth::id(); // Ambil ID pengguna yang sedang login
    
        $colorTol->update($data);

        return response()->json([
            'message' => 'Color Tol updated successfully!',
            'colorTol' => $colorTol,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $colorTol = ColorTol::findOrFail($id);
            $colorTol->delete();
    
            return response()->json(['message' => 'color Tol deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete brand.'], 500);
        }
    }
}
