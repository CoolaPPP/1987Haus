<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\RecommendProduct;
use Illuminate\Http\Request;

class RecommendProductController extends Controller
{
    public function index()
    {
        $recommended = RecommendProduct::with('product')->latest()->get();
        return view('admin.recommend_products.index', compact('recommended'));
    }

    public function create()
    {
        // ดึง ID ของสินค้าที่ถูกแนะนำไปแล้ว
        $recommended_ids = RecommendProduct::pluck('product_id');
        // ดึงเฉพาะสินค้าที่ยังไม่ถูกแนะนำ
        $products = Product::whereNotIn('id', $recommended_ids)->get();
        return view('admin.recommend_products.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id|unique:recommend_products,product_id',
            'recommend_note' => 'nullable|string',
        ]);
        RecommendProduct::create($request->all());
        return redirect()->route('admin.recommend-products.index')->with('success', 'Added to recommended list.');
    }

    public function edit(RecommendProduct $recommendProduct)
    {
        return view('admin.recommend_products.edit', compact('recommendProduct'));
    }

    public function update(Request $request, RecommendProduct $recommendProduct)
    {
        $request->validate(['recommend_note' => 'nullable|string']);
        $recommendProduct->update($request->all());
        return redirect()->route('admin.recommend-products.index')->with('success', 'Recommendation updated.');
    }

    public function destroy(RecommendProduct $recommendProduct)
    {
        $recommendProduct->delete();
        return back()->with('success', 'Removed from recommended list.');
    }
}