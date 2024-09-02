<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sizes = Size::all();
        return response()->json(['sizes' => $sizes]);
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
            'fg_width' => 'required|string',
            'fg_length' => 'required|string',
            'size_name' => 'required|string|max:255',
            'size_code' => 'required|string',
        ]);

        $data = $request->only('size_name', 'size_code', 'fg_width', 'fg_length');
        $data['created_by'] = Auth::id(); // Ambil ID pengguna yang sedang login
    
        Size::create($data);

        return response()->json([
            'message' => 'Size created successfully!',
            'size' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Size $size)
    {
        $request->validate([
            'fg_width' => 'required|string',
            'fg_length' => 'required|string',
            'size_name' => 'required|string|max:255',
            'size_code' => 'required|string',
        ]);

        $data = $request->only('size_name', 'size_code', 'fg_width', 'fg_length');
        $data['updated_by'] = Auth::id();
        $size->update($data);

        return response()->json([
            'message' => 'Size updated successfully!',
            'size' => $size,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $size = Size::findOrFail($id);
            $size->delete();
    
            return response()->json(['message' => 'Size deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete brand.'], 500);
        }
    }
}
