@extends('layouts.app')

@section('title', '1987 Haus | Owner Login')

@section('content')
<style>
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
<div class="container mt-5 pb-5">
    <h2>เข้าสู่ระบบสำหรับเจ้าของร้าน</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
        
        @csrf

        <div class="form-group pt-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="form-group pt-3 pb-3">
            <label for="password">รหัสผ่าน</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-theme btn-lg">เข้าสู่ระบบ</button>
    </form>
</div>
@endsection