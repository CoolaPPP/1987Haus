<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function index()
    {
        $productTypes = ProductType::latest()->get();
        return view('admin.product_types.index', compact('productTypes'));
    }

    public function store(Request $request)
    {
        $request->validate(['producttype_name' => 'required|string|max:255|unique:product_types']);
        ProductType::create($request->all());
        return back()->with('success', 'เพิ่มข้อมูลประเภทสินค้าใหม่สำเร็จ');
    }

    public function edit($id)
    {
        $productType = ProductType::findOrFail($id);
        return view('admin.product_types.edit', compact('productType'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'producttype_name' => 'required|string|max:255|unique:product_types,producttype_name,' . $id
        ]);

        $productType = ProductType::findOrFail($id);
        $productType->update($request->all());

        return redirect()->route('admin.product-types.index')->with('success', 'แก้ไขข้อมูลประเภทสินค้าสำเร็จ');
    }
    
    public function destroy($id)
    {
        $productType = ProductType::findOrFail($id);
        $productType->delete();
        return back()->with('success', 'ลบข้อมูลประเภทสินค้าสำเร็จ');
    }
}