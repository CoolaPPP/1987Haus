@extends('admin.layouts.app')

@section('title', 'Owner Homepage')

@section('content-header', 'ยินดีต้อนรับสู่หน้าหลักของเจ้าของร้าน')

@section('content')

<style> 
    .cart-table thead { 
        background-color: #504b38; color: #f8f3d9; 
    }

    .btn-theme { 
        background-color: #504b38; color: #f8f3d9; border: none; 
    }
    
    .btn-theme:hover { 
        background-color: #b9b28a; color: #504b38; 
    } 
    
    .btn-outline-theme { 
        border: 1px solid #504b38; color: #504b38; background-color: transparent; 
    } 
    
    .btn-outline-theme:hover { 
        background-color: #504b38; color: #f8f3d9; 
    } 
</style>

<div class="my-3">
    <h3>วันที่และเวลาปัจจุบัน</h3>
    <p id="clock" style="font-size: 1.5rem; font-weight: bold; color: #504b38;"></p>

    <div>
        <h5>ไปหน้าจัดการการขาย</h5>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-theme btn-lg">จัดการการขาย</a>
    </div>
</div>
@endsection

<script>
    function updateClock() {
        let now = new Date();

        // เดือนภาษาไทย
        const months = [
            "มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน",
            "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"
        ];

        let day = now.getDate();
        let month = months[now.getMonth()];
        let year = now.getFullYear(); // ปีสากล (ค.ศ.)
        let time = now.toLocaleTimeString('th-TH', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

        document.getElementById('clock').innerHTML =
            `${day} ${month} ${year} ${time}`;
    }

    setInterval(updateClock, 1000);
    updateClock();
</script>
