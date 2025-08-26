@extends('admin.layouts.app')

@section('title', 'Product Types')

@section('content-header', 'หน้าจัดการข้อมูลประเภทสินค้า')

@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header pt-3 ">
                <h3 class="card-title">ประเภทสินค้าทั้งหมด</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>รหัสประเภทสินค้า</th>
                            <th>ชื่อประเภทสินค้า</th>
                            <th>การจัดการข้อมูล</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productTypes as $type)
                        <tr>
                            <td>{{ $type->id }}</td>
                            <td>{{ $type->producttype_name }}</td>
                            <td class="d-flex gap-1">
                                <a href="{{ route('admin.product-types.edit', $type->id) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                                <form action="{{ route('admin.product-types.destroy', $type->id) }}" method="POST" onsubmit="return confirm('ต้องการลบใช่หรือไม่');">
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
        </div>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-header pt-3"><h3 class="card-title ">เพิ่มประเภทสินค้า</h3></div>
            <div class="card-body">
                @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                <form action="{{ route('admin.product-types.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>ชื่อประเภทสินค้า</label>
                        <input type="text" name="producttype_name" class="form-control @error('producttype_name') is-invalid @enderror" required>
                        @error('producttype_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-success">เพิ่มประเภทสินค้า</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection