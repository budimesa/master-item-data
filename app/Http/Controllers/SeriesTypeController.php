<?php

namespace App\Http\Controllers;

use App\Models\SeriesType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeriesTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seriesTypes = SeriesType::all();
        return response()->json(['seriesTypes' => $seriesTypes]);
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
            'series_type_name' => 'required|string|max:255',
            'series_type_code' => 'required|string',
        ]);

        $data = $request->only('series_type_name', 'series_type_code');
        $data['created_by'] = Auth::id(); // Ambil ID pengguna yang sedang login
    
        SeriesType::create($data);

        return response()->json([
            'message' => 'Series Type created successfully!',
            'seriesType' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SeriesType $seriesType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SeriesType $seriesType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SeriesType $seriesType)
    {
        $request->validate([
            'series_type_name' => 'required|string|max:255',
            'series_type_code' => 'required|string',
        ]);

        $data = $request->only('series_type_name', 'series_type_code');
        $data['updated_by'] = Auth::id(); // Ambil ID pengguna yang sedang login
    
        $seriesType->update($data);

        return response()->json([
            'message' => 'Series Type updated successfully!',
            'seriesType' => $seriesType,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $seriesType = SeriesType::findOrFail($id);
            $seriesType->delete();
    
            return response()->json(['message' => 'Series Type deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete brand.'], 500);
        }
    }
}
