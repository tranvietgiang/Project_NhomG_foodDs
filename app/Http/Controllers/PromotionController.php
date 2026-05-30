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
            'code' => 'required|string|max:50|unique:promotions',
            'name' => 'required|string|max:100',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0|max:999999999',
            'usage_limit' => 'nullable|integer|min:1|max:999999',
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
            'code' => 'required|string|max:50|unique:promotions,code,' . $promotion->id,
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
        $validated = $request->validate([
            'search' => 'nullable|string|max:100',
        ], [
            'search.max' => 'Từ khóa tìm kiếm không được vượt quá 100 ký tự.',
        ]);

        $search = trim($validated['search'] ?? '');

        $promotions = Promotion::when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('code', 'LIKE', "%{$search}%");
        })
            ->latest()
            ->paginate(5);

        return view('component.content.discount.promotions', compact('promotions'));
    }
}
