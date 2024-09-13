<?php

namespace App\Http\Controllers;

use App\Models\InventoryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryTypeController extends Controller
{
    public function index(Request $request)
    {
        $inventoryTypes = InventoryType::all();
        return response()->json(['inventoryTypes' => $inventoryTypes]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventory_type_name' => 'required|string|max:255',
            'group' => 'required|string',
        ]);

        $data = $request->only('inventory_type_name', 'group');
        $data['created_by'] = Auth::id(); // Ambil ID pengguna yang sedang login

        InventoryType::create($data);

        return response()->json([
            'message' => 'Inventory type created successfully!',
            'inventoryType' => $data,
        ]);
    }

    public function update(Request $request, InventoryType $inventoryType)
    {
        $request->validate([
            'inventory_type_name' => 'required|string|max:255',
            'group' => 'required|string',
        ]);

        $data = $request->only('inventory_type_name', 'group');
        $data['updated_by'] = Auth::id(); // Ambil ID pengguna yang sedang login

        $inventoryType->update($data);

        return response()->json([
            'message' => 'Inventory type updated successfully!',
            'inventoryType' => $data,
        ]);
    }

    public function destroy(InventoryType $inventoryType)
    {
        $inventoryType->delete();
        return response()->json([
            'message' => 'Inventory type deleted successfully!',
        ]);
    }


}
