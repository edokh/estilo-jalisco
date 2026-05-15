<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FoodItem;
use Illuminate\Http\Request;

class FoodItemController extends Controller
{
    public function index()
    {
        $items = FoodItem::with('category')->orderBy('order', 'asc')->get();
        return view('admin.food-items.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::where('active', true)->get();
        return view('admin.food-items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'available' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ]);

        $validated['available'] = $request->has('available');
        $validated['order'] = $request->input('order', 0);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('food-items', 'public');
        }

        FoodItem::create($validated);

        return redirect()->route('admin.food-items.index')
            ->with('success', 'Food item created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(FoodItem $foodItem)
    {
        $categories = Category::where('active', true)->get();
        return view('admin.food-items.edit', compact('foodItem', 'categories'));
    }

    public function update(Request $request, FoodItem $foodItem)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'available' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ]);

        $validated['available'] = $request->has('available');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('food-items', 'public');
        }

        $foodItem->update($validated);

        return redirect()->route('admin.food-items.index')
            ->with('success', 'Food item updated successfully.');
    }

    public function destroy(FoodItem $foodItem)
    {
        $foodItem->delete();

        return redirect()->route('admin.food-items.index')
            ->with('success', 'Food item deleted successfully.');
    }
}
