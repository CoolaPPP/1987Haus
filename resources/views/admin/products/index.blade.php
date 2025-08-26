@extends('admin.layouts.app')

@section('title', 'Products')

@section('content-header', 'หน้าจัดการข้อมูลสินค้า')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">สินค้าทั้งหมด</h3>
        <div class="card-tools">
            <a href="{{ route('admin.products.create') }}" class="btn btn-success">เพิ่มสินค้า</a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>รูปภาพ</th>
                    <th>ชื่อสินค้า</th>
                    <th>ประเภทสินค้า</th>
                    <th>ราคา</th>
                    <th>การจัดการข้อมูล</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    @php
                        // สร้าง object ImageKit ชั่วคราวเพื่อสร้าง URL
                        $imageKit = new \ImageKit\ImageKit(
                            env('IMAGEKIT_PUBLIC_KEY'),
                            env('IMAGEKIT_PRIVATE_KEY'),
                            env('IMAGEKIT_URL_ENDPOINT')
                        );
                    @endphp
                
                    <td><img src="{{ $imageKit->url(['path' => $product->product_pic]) }}" width="50"></td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->productType->producttype_name }}</td>
                    <td>{{ number_format($product->product_price, 2) }}</td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('ต้องการลบใช่หรือไม่');">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">ลบ</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $products->links() }}
    </div>

</div>
@endsection