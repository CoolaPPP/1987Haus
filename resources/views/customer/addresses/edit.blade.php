@extends('layouts.app')

@section('title', '1987 Haus | Edit Shipping Address')

@section('content')
<style>
    .card {
        background-color: #f8f3d9;
        border: 1px solid #ebe5c2;
    }
    .card-header {
        background-color: #504b38;
        color: #f8f3d9;
        font-weight: bold;
    }
    .btn-theme {
        background-color: #504b38;
        color: #f8f3d9;
        border: none;
    }
    .btn-theme:hover {
        background-color: #b9b28a;
        color: #504b38;
    }
    .btn-outline-theme {
        border: 1px solid #504b38;
        color: #504b38;
    }
    .btn-outline-theme:hover {
        background-color: #504b38;
        color: #f8f3d9;
    }
</style>
<div class="container py-5" style="background-color: #f8f3d9;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Card -->
            <div class="card shadow-sm border-0" style="background-color: #ebe5c2;">
                <div class="card-header text-white text-center" style="background-color: #504b38;">
                    <h4 class="mb-0">แก้ไขที่อยู่สำหรับจัดส่งสินค้า</h4>
                </div>
                <div class="card-body">
                    
                    <!-- Show validation errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('addresses.update', $address->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="address" class="fw-bold" style="color: #504b38;">ที่อยู่ <span class="text-danger">*</span></label>
                            <textarea 
                                name="address" 
                                id="address" 
                                class="form-control border-0 shadow-sm" 
                                rows="4" 
                                style="background-color: #f8f3d9;"
                                placeholder="ระบุที่อยู่จัดส่งสินค้า" 
                                required>{{ old('address', $address->address) }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="address_note" class="fw-bold" style="color: #504b38;">ข้อมูลที่อยู่เพิ่มเติม <small class="text-muted">(ไม่บังคับ)</small></label>
                            <textarea 
                                name="address_note" 
                                id="address_note" 
                                class="form-control border-0 shadow-sm" 
                                rows="2" 
                                style="background-color: #f8f3d9;"
                                placeholder="เช่น ชื่อสถานที่,ชั้น,จุดสังเกต">{{ old('address_note', $address->address_note) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-theme btn-lg mt-4 w-100">
                                ยืนยัน
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End Card -->
        </div>
    </div>
</div>
@endsection
