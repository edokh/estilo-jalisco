<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\FoodItem;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::with('foodItem')->orderBy('created_at', 'desc')->get();
        return view('admin.discounts.index', compact('discounts'));
    }

    public function create()
    {
        $foodItems = FoodItem::where('available', true)->get();
        return view('admin.discounts.create', compact('foodItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'food_item_id' => 'nullable|exists:food_items,id',
            'name' => 'required',
            'description' => 'nullable',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'active' => 'nullable|boolean',
        ]);

        $validated['active'] = $request->has('active');

        Discount::create($validated);

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Discount $discount)
    {
        $foodItems = FoodItem::where('available', true)->get();
        return view('admin.discounts.edit', compact('discount', 'foodItems'));
    }

    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'food_item_id' => 'nullable|exists:food_items,id',
            'name' => 'required',
            'description' => 'nullable',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'active' => 'nullable|boolean',
        ]);

        $validated['active'] = $request->has('active');

        $discount->update($validated);

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount updated successfully.');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount deleted successfully.');
    }
}
