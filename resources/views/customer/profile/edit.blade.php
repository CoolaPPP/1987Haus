@extends('layouts.app')

@section('title', '1987 Haus | Edit Profile')

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
<div class="container py-5" style="background-color: #f8f3d9; border-radius: 12px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-center mb-4" style="color: #504b38; font-weight: bold;">แก้ไขข้อมูลส่วนตัว</h2>

            @if(session('success'))
                <div class="alert alert-success border-0" style="background-color: #b9b28a; color: #504b38;">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger border-0" style="background-color: #b94a48; color: #fff;">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('customer.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                {{-- General Information --}}
                <div class="card shadow-sm mb-4" style="border: none; background-color: #ebe5c2;">
                    <div class="card-body">
                        <h5 class="card-title" style="color: #504b38;">ข้อมูลส่วนตัว</h5>
                        <div class="form-group mb-3">
                            <label for="name" style="color: #504b38;">ชื่อ</label>
                            <input type="text" id="name" name="name" 
                                class="form-control" 
                                style="border: 1px solid #b9b28a; background-color: #f8f3d9;"
                                value="{{ old('name', $customer->name) }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" style="color: #504b38;">Email</label>
                            <input type="email" id="email" name="email" 
                                class="form-control" 
                                style="border: 1px solid #b9b28a; background-color: #f8f3d9;"
                                value="{{ old('email', $customer->email) }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="tel" style="color: #504b38;">เบอร์โทรศัพท์</label>
                            <input type="text" id="tel" name="tel" 
                                class="form-control" 
                                style="border: 1px solid #b9b28a; background-color: #f8f3d9;"
                                value="{{ old('tel', $customer->tel) }}">
                        </div>
                    </div>
                </div>

                {{-- Change Password --}}
                <div class="card shadow-sm" style="border: none; background-color: #ebe5c2;">
                    <div class="card-body">
                        <h5 class="card-title" style="color: #504b38;">เปลี่ยนรหัสผ่าน</h5>
                        <p class="text-muted small">หากไม่ต้องการเปลี่ยนรหัสผ่าน สามารถเว้นช่องนี้ให้ว่างได้</p>
                        <div class="form-group mb-3">
                            <label for="password" style="color: #504b38;">รหัสผ่านใหม่</label>
                            <input type="password" id="password" name="password" 
                                class="form-control" 
                                style="border: 1px solid #b9b28a; background-color: #f8f3d9;">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password_confirmation" style="color: #504b38;">ยืนยันรหัสผ่านใหม่</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" 
                                class="form-control" 
                                style="border: 1px solid #b9b28a; background-color: #f8f3d9;">
                        </div>
                    </div>
                </div>

                <button type="submit" 
                    class="btn btn-theme btn-lg mt-4 w-100" >
                    ยืนยัน
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
