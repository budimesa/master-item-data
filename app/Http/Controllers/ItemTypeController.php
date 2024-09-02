<?php

namespace App\Http\Controllers;

use App\Models\ItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ItemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itemTypes = ItemType::all();
        return response()->json(['itemTypes' => $itemTypes]);
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
            'type_name' => 'required|string|max:255',
            'type_code' => 'required|string',
        ]);

        $data = $request->only('type_name', 'type_code');
        $data['created_by'] = Auth::id(); // Ambil ID pengguna yang sedang login
    
        ItemType::create($data);

        return response()->json([
            'message' => 'Item Type created successfully!',
            'itemType' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemType $itemType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemType $itemType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemType $itemType)
    {
        $request->validate([
            'type_name' => 'required|string|max:255',
            'type_code' => 'required|string',
        ]);

        $data = $request->only('type_name', 'type_code');
        $data['updated_by'] = Auth::id(); // Ambil ID pengguna yang sedang login
    
        $itemType->update($data);

        return response()->json([
            'message' => 'Item Type updated successfully!',
            'itemType' => $itemType,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $itemType = ItemType::findOrFail($id);
            $itemType->delete();
    
            return response()->json(['message' => 'Item Type deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete brand.'], 500);
        }
    }
}
