<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = Color::all();
        return response()->json(['colors' => $colors]);
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
        request()->validate([
            'color_name' => 'required|string|max:255',
            'color_code' => 'required|string',
        ]);

        $data = $request->only('color_name', 'color_code');
        $data['created_by'] = Auth::id(); // Ambil ID pengguna yang sedang login
    
        Color::create($data);

        return response()->json([
            'message' => 'Color created successfully!',
            'color' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Color $color)
    {
        $request->validate([
            'color_name' => 'required|string|max:255',
            'color_code' => 'required|string',
        ]);

        $data = $request->only('color_name', 'color_code');
        $data['updated_by'] = Auth::id();
    
        $color->update($data);

        return response()->json([
            'message' => 'Color updated successfully!',
            'color' => $color,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $color = Color::findOrFail($id);
            $color->delete();
    
            return response()->json(['message' => 'Color deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete brand.'], 500);
        }
    }
}
