<?php

namespace App\Http\Controllers;

use App\Models\Density;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DensityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $densities = Density::all();
        return response()->json(['densities' => $densities]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'density_name' => 'required|string|max:255',
            'density_code' => 'required|string',
        ]);

        $data = $request->only('density_name', 'density_code'); 
        $data['created_by'] = Auth::id(); // Ambil ID pengguna yang sedang login
    
        Density::create($data);

        return response()->json([
            'message' => 'Density created successfully!',
            'density' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Density $density)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Density $density)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Density $density)
    {
        $request->validate([
            'density_name' => 'required|string|max:255',
            'density_code' => 'required|string',
        ]);

        $data = $request->only('density_name', 'density_code');
        $data['updated_by'] = Auth::id(); // Ambil ID pengguna yang sedang login

        $density->update($data);

        return response()->json([
            'message' => 'Density updated successfully!',
            'density' => $density,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $density = Density::findOrFail($id);
            $density->delete();
    
            return response()->json(['message' => 'Density deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete brand.'], 500);
        }
    }
}
