@extends('layouts.app')

@section('title', '1987 Haus | Owner Login')

@section('content')
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
        <button type="submit" class="btn" style="background-color: #b9b28a; color: #504b38; font-weight:bold;">เข้าสู่ระบบ</button>
    </form>
</div>
@endsection