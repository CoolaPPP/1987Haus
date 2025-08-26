@extends('layouts.app')

@section('title', '1987 Haus | Login')

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
    <h2>เข้าสู่ระบบ</h2>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <div class="form-group pt-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="form-group pt-3 pb-3">
            <label for="password">รหัสผ่าน</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-theme btn-lg">เข้าสู่ระบบ</button>
        
        <hr>
        <p>คุณยังไม่มีบัญชีใช่ไหม <a href="{{ route('register') }}">ลงทะเบียนที่นี่</a></p>
    </form>
</div>
@endsection