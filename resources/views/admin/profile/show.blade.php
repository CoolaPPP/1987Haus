@extends('admin.layouts.app')

@section('title', 'Profile')

@section('content-header', 'ข้อมูลเจ้าของร้าน')

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
        <div class="card card-secondary card-outline">
            <div class="card-body box-profile">
                <h3 class="profile-username text-center">{{ $owner->name }}</h3>

                <p class="text-muted text-center">เจ้าของร้าน</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Email</b> <a class="float-right">{{ $owner->email }}  </a>
                    </li>
                    <li class="list-group-item">
                        <b>เบอร์โทร</b> <a class="float-right">{{ $owner->tel ?? 'N/A' }}  </a>
                    </li>
                </ul>
                <a href="{{ route('admin.profile.edit') }}" class="btn btn-theme btn-block"><b>แก้ไขข้อมูล</b></a>
            </div>
        </div>
    </div>
</div>
@endsection