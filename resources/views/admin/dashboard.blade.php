
@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content-header', 'หน้าจัดการการขาย')

@section('content')
<div class="container-fluid">
  <div class="row mb-4">
    <div class="col">
      <h3 class="fw-bold">การขายสินค้า</h3>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-lg-3 col-md-6">
      <div class="small-box bg-white h-100 shadow-sm">
        <div class="inner">
          <h3>{{ $newOrdersCount }}</h3>
          <p>คำสั่งซื้อใหม่</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="{{ route('admin.orders.new') }}" class="small-box-footer">แสดงคำสั่งซื้อใหม่ <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-md-6">
      <div class="small-box bg-info text-black h-100 shadow-sm">
          <div class="inner">
              <h3>{{ $shippingOrdersCount }}</h3>
              <p>รายการขายที่กำลังจัดส่ง</p>
          </div>
          <div class="icon">
              <i class="ion ion-android-car"></i> 
          </div>
          <a href="{{ route('admin.orders.shipping') }}" class="small-box-footer text-black">
              แสดงรายการขายที่กำลังจัดส่ง <i class="fa fa-arrow-circle-right"></i>
          </a>
      </div>
    </div>

    <div class="col-lg-3 col-md-6">
      <div class="small-box bg-success h-100 shadow-sm">
          <div class="inner">
              <h3>{{ $deliveredOrdersCount }}</h3>
              <p>รายการที่จัดส่งสำเร็จ</p>
          </div>
          <div class="icon"><i class="ion ion-checkmark-circled"></i></div>
          <a href="{{ route('admin.orders.delivered') }}" class="small-box-footer">แสดงรายการที่จัดส่งสำเร็จ<i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
      <div class="small-box bg-danger h-100 text-white shadow-sm">
          <div class="inner">
              <h3>{{ $canceledOrdersCount }}</h3>
              <p>รายการยกเลิกการสั่ง</p>
          </div>
          <div class="icon">
              <i class="ion ion-close-circled"></i>
          </div>
          <a href="{{ route('admin.canceled-orders.index') }}" class="small-box-footer text-white">
              แสดงรายการยกเลิกการสั่ง <i class="fa fa-arrow-circle-right"></i>
          </a>
      </div>
  </div>
  <hr class="my-4">
</div>
@endsection