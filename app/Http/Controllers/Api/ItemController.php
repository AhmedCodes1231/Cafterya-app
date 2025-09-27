<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    // List items with pagination, filter by category_id or name
    public function index(Request $request)
    {
        $query = Item::with('category');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $items = $query->paginate(10);

        return response()->json($items);
    }

    // Show item details
    public function show(Item $item)
    {
        $item->load('category');

        return response()->json($item);
    }

    // Create item with validation
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:items,name',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'stock' => 'nullable|integer|min:0',
        ]);

        $item = Item::create($data);

        return response()->json([
            'message' => 'Item created successfully',
            'item' => $item
        ], 201);
    }

    // Update item with validation
    public function update(Request $request, Item $item)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('items')->ignore($item->id)
            ],
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'stock' => 'nullable|integer|min:0',
        ]);

        $item->update($data);

        return response()->json([
            'message' => 'Item updated successfully',
            'item' => $item
        ]);
    }

    // Delete item
    public function destroy(Item $item)
    {
        $item->delete();

        return response()->json([
            'message' => 'Item deleted successfully'
        ]);
    }
}
