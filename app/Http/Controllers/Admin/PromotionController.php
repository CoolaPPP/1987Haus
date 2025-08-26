<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::latest()->paginate(10);
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.promotions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|max:50|unique:promotions',
            'promotion_name' => 'required|string|max:255',
            'promotion_discount' => 'required|numeric|min:0',
            'promotion_start' => 'required|date',
            'promotion_end' => 'required|date|after_or_equal:promotion_start',
        ]);

        Promotion::create($request->all());
        return redirect()->route('admin.promotions.index')->with('success', 'เพิ่มโปรโมชันสําเร็จ');
    }

    public function edit(Promotion $promotion)
    {
        return view('admin.promotions.edit', compact('promotion'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
            'promotion_name' => 'required|string|max:255',
            'promotion_discount' => 'required|numeric|min:0',
            'promotion_start' => 'required|date',
            'promotion_end' => 'required|date|after_or_equal:promotion_start',
        ]);
        
        $promotion->update($request->except('id'));
        return redirect()->route('admin.promotions.index')->with('success', 'แก้ไขโปรโมชันสำเร็จ');
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return back()->with('success', 'ลบโปรโมชันสำเร็จ');
    }
}
