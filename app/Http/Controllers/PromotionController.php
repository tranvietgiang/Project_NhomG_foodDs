<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotion;

class PromotionController extends Controller
{
    //
    public function index()
    {
        $promotions = Promotion::latest()->paginate(5);
        return view('component.content.discount.promotions', compact('promotions'));
    }

    public function create()
    {
        return view('promotions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:promotions',
            'name' => 'required',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        Promotion::create($validated);
        return redirect()->route('promotions.index')
            ->with('success', 'Tạo mã giảm giá thành công!');
    }

    public function edit(Promotion $promotion)
    {
        return view('admin.promotions.edit', compact('promotion'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            'code' => 'required|unique:promotions,code,' . $promotion->id,
        ]);

        $promotion->update($validated);
        return redirect()->route('promotions.index')
            ->with('success', 'Cập nhật mã giảm giá thành công!');
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return redirect()->route('promotions.index')
            ->with('success', 'Xóa mã giảm giá thành công!');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $promotions = Promotion::when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('code', 'LIKE', "%{$search}%");
        })
            ->latest()
            ->paginate(5);

        return view('component.content.discount.promotions', compact('promotions'));
    }
}