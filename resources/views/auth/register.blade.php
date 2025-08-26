@extends('layouts.app')

@section('title', '1987 Haus | Register')

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
    <h2>ลงทะเบียนผู้ใช้</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST" onsubmit="return validateForm()">
        @csrf 

        <div class="form-group pt-3">
            <label for="name">ชื่อ</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group pt-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="form-group pt-3">
            <label for="tel">เบอร์โทรศัพท์</label>
            <input type="text" name="tel" id="tel" class="form-control" value="{{ old('tel') }}">
        </div>

        <div class="form-group pt-3">
            <label for="password">รหัสผ่าน</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="form-group pt-3 pb-3">
            <label for="password_confirmation">ยืนยันรหัสผ่าน</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-theme btn-lg">ลงทะเบียน</button>
    
        <hr>
        <p>คุณมีบัญชีแล้วใช่ไหม <a href="{{ route('login') }}">เข้าสู่ระบบที่นี่</a></p>
    </form>
</div>

<script>
function validateForm() {
    const password = document.getElementById('password').value;
    const passwordConfirmation = document.getElementById('password_confirmation').value;

    if (password.length < 6) {
        alert('Password must be at least 6 characters long.');
        return false; 
    }

    if (password !== passwordConfirmation) {
        alert('Passwords do not match.');
        return false; 
    }
    return true; 
}
</script>
@endsection