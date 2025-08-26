@extends('admin.layouts.app')

@section('title', 'Edit Profile')

@section('content-header', 'แก้ไขข้อมูลเจ้าของร้าน')

@section('content')
<style>
    .cart-table thead {
        background-color: #504b38;
        color: #f8f3d9;
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
        background-color: transparent;
    }
    .btn-outline-theme:hover {
        background-color: #504b38;
        color: #f8f3d9;
    }
</style>
<div class="row">
    <div class="col-md-8">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card ">
                <div class="card-header"><h3 class="card-title">ข้อมูลส่วนตัว</h3></div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">ชื่อ</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $owner->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $owner->email) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="tel">เบอร์โทรศัพท์</label>
                        <input type="text" id="tel" name="tel" class="form-control" value="{{ old('tel', $owner->tel) }}">
                    </div>
                </div>
            </div>
            <div class="card card-danger">
                <div class="card-header"><h3 class="card-title">เปลี่ยนรหัสผ่าน</h3></div>
                <div class="card-body">
                    <p class="text-muted">หากไม่ต้องการเปลี่ยนรหัสผ่าน สามารถเว้นช่องนี้ให้ว่างได้</p>
                    <div class="form-group">
                        <label for="password">รหัสผ่านใหม่</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">ยืนยันรหัสผ่านใหม่</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-theme btn-block">ยืนยัน</button>
        </form>
        <hr>
        <div>
            <a href="{{ route('admin.profile.show') }}" class="btn btn-outline-theme btn-block"><b>กลับไปหน้าโปรไฟล์</b></a>
        </div>
    </div>
</div>
@endsection