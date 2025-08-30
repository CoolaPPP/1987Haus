<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use ImageKit\ImageKit; // 1. Import คลาสหลักของ ImageKit

class ProductController extends Controller
{
    private $imageKit;

    // 2. สร้าง Constructor เพื่อเตรียม ImageKit object ไว้ใช้งาน
    public function __construct()
    {
        $this->imageKit = new ImageKit(
            env('IMAGEKIT_PUBLIC_KEY'),
            env('IMAGEKIT_PRIVATE_KEY'),
            env('IMAGEKIT_URL_ENDPOINT')
        );
    }

    public function index()
    {
        $products = Product::with('productType')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $productTypes = ProductType::all();
        return view('admin.products.create', compact('productTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'producttype_id' => 'required|exists:product_types,id',
            'product_price' => 'required|numeric|min:0',
            'product_pic' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // แปลงไฟล์เป็น base64 ก่อนส่ง
        $file_base64 = base64_encode(file_get_contents($request->file('product_pic')));
        
        // สร้าง object ImageKit ชั่วคราวเพื่ออัปโหลด
        $imageKit = new \ImageKit\ImageKit(
            env('IMAGEKIT_PUBLIC_KEY'),
            env('IMAGEKIT_PRIVATE_KEY'),
            env('IMAGEKIT_URL_ENDPOINT')
        );

        $uploadResult = $imageKit->upload([
            'file' => 'data:image/png;base64,' . $file_base64,
            'fileName' => uniqid() . '.' . $request->file('product_pic')->extension(),
            'folder' => '/1987haus/products/',
        ]);
        
        Product::create([
            'product_name' => $request->product_name,
            'producttype_id' => $request->producttype_id,
            'product_price' => $request->product_price,
            'product_pic' => $uploadResult->result->filePath,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'เพิ่มข้อมูลสินค้าใหม่สําเร็จ');
    }

    public function edit(Product $product)
    {
        $productTypes = ProductType::all();
        return view('admin.products.edit', compact('product', 'productTypes'));
    }
    
    public function update(Request $request, Product $product)
    {
        // 1. ตรวจสอบข้อมูลที่ส่งมา (รูปภาพไม่จำเป็นต้องมีเสมอไป)
        $request->validate([
            'product_name' => 'required|string|max:255',
            'producttype_id' => 'required|exists:product_types,id',
            'product_price' => 'required|numeric|min:0',
            'product_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. เตรียมข้อมูลที่จะอัปเดต (ไม่รวมรูปภาพ)
        $updateData = $request->except('product_pic');

        // 3. ตรวจสอบว่ามีการส่งไฟล์รูปภาพใหม่มาหรือไม่
        if ($request->hasFile('product_pic')) {
            
            // 3.1 ถ้ามีรูปเก่าอยู่ ให้ลบออกจาก ImageKit ก่อน
            if ($product->product_pic) {
                // ค้นหา fileId จาก filePath ที่เราเก็บไว้
                $files = $this->imageKit->listFiles(['searchQuery' => 'filePath = "' . $product->product_pic . '"']);
                if (!empty($files->result)) {
                    // ใช้ fileId ที่หาเจอในการลบไฟล์
                    $this->imageKit->deleteFile($files->result[0]->fileId);
                }
            }

            // 3.2 อัปโหลดรูปใหม่ด้วยวิธี base64
            $file_base64 = base64_encode(file_get_contents($request->file('product_pic')));
            $uploadResult = $this->imageKit->upload([
                'file' => 'data:image/png;base64,' . $file_base64,
                'fileName' => uniqid() . '.' . $request->file('product_pic')->extension(),
                'folder' => '/1987haus/products/',
            ]);

            // 3.3 เพิ่ม path ของรูปใหม่เข้าไปในข้อมูลที่จะอัปเดต
            $updateData['product_pic'] = $uploadResult->result->filePath;
        }

        // 4. อัปเดตข้อมูลลงในฐานข้อมูล
        $product->update($updateData);

        return redirect()->route('admin.products.index')->with('success', 'แก้ไขข้อมูลสินค้าสําเร็จ');
    }

    public function destroy(Product $product)
    {
        if ($product->product_pic) {
            // หา fileId จาก filePath เพื่อนำไปลบ
            $files = $this->imageKit->listFiles(['searchQuery' => 'filePath = "' . $product->product_pic . '"']);
            if (!empty($files->result)) {
                $this->imageKit->deleteFile($files->result[0]->fileId);
            }
        }
        $product->delete();
        return back()->with('success', 'ลบข้อมูลสินค้าสําเร็จ');
    }
}