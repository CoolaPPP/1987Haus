@extends('admin.layouts.app')

@section('title', 'Recommended Products')

@section('content-header', 'หน้าจัดการข้อมูลสินค้าแนะนำ')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">สินค้าแนะนำทั้งหมด</h3>
        <div class="card-tools">
            <a href="{{ route('admin.recommend-products.create') }}" class="btn btn-success">เพิ่มสินค้าแนะนำ</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead><tr><th>สินค้า</th><th>ข้อความ</th><th>การจัดการข้อมูล</th></tr></thead>
            <tbody>
                @foreach($recommended as $item)
                <tr>
                    <td>
                        @php
                            // สร้าง object ImageKit ชั่วคราวเพื่อสร้าง URL
                            $imageKit = new \ImageKit\ImageKit(
                                env('IMAGEKIT_PUBLIC_KEY'),
                                env('IMAGEKIT_PRIVATE_KEY'),
                                env('IMAGEKIT_URL_ENDPOINT')
                            );
                        @endphp
                        <img src="{{ $imageKit->url(['path' => $item->product->product_pic, 'transformation' => [['width' => 100]]]) }}" width="40" class="mr-2">
                        {{ $item->product->product_name }}
                    </td>
                    <td>{{ $item->recommend_note }}</td>
                    <td>
                        <a href="{{ route('admin.recommend-products.edit', $item->id) }}" class="btn btn-sm btn-warning">แก้ไข</a>
                        <form action="{{ route('admin.recommend-products.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf 
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">ลบ</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection