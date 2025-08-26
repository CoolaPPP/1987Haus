<!-- Main Sidebar -->
<aside class="main-sidebar elevation-4 sidebar-dark-primary">
        <!-- Brand Logo -->
        <a href="{{ route('admin.main.index') }}" class="brand-link" style="background:#504b38; color:#f8f3d9;">
            <span class="brand-text font-weight-bold ps-3">1987 Haus Dashboard</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- User panel -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                    <a href="{{ route('admin.profile.show') }}" class="d-block fw-bold" style="color:#504b38;">
                        {{ Auth::guard('admin')->user()->name }}
                    </a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column fw-bold" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <p>จัดการการขาย</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.payments.index') }}" class="nav-link active">
                            <i class="fa-solid fa-money-check-dollar"></i>
                            <p>ข้อมูลการชำระเงิน</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.order-confirmations.index') }}" class="nav-link active">
                            <i class="fa-solid fa-truck-fast"></i>
                            <p>ข้อมูลการรับสินค้า</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.order-cancels.index') }}" class="nav-link active">
                            <i class="fa-solid fa-ban"></i>
                            <p>ข้อมูลการยกเลิกการสั่งซื้อ</p>
                        </a>
                    </li>

                    <hr>

                    <li class="nav-item">
                        <a href="{{ route('admin.products.index') }}" class="nav-link active">
                            <i class="fa-solid fa-box-archive"></i>
                            <p>จัดการข้อมูลสินค้า</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.product-types.index') }}" class="nav-link active">
                            <i class="fa-solid fa-boxes-stacked"></i>
                            <p>จัดการข้อมูลประเภทสินค้า</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.recommend-products.index') }}" class="nav-link active">
                            <i class="fa-solid fa-star"></i>
                            <p>จัดการข้อมูลสินค้าแนะนำ</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.promotions.index') }}" class="nav-link active">
                            <i class="fa-solid fa-coins"></i>
                            <p>จัดการข้อมูลโปรโมชัน</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.order-statuses.index') }}" class="nav-link active">
                            <i class="fa-solid fa-truck"></i>
                            <p>จัดการข้อมูลสถานะคำสั่งซื้อ</p>
                        </a>
                    </li>

                    <hr>

                    <li class="nav-item">
                        <a href="{{ route('admin.customers.index') }}" class="nav-link active">
                            <i class="fa-solid fa-user"></i>
                            <p>ข้อมูลลูกค้า</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.shipping-addresses.index') }}" class="nav-link active">
                            <i class="fa-solid fa-house"></i>
                            <p>ข้อมูลที่อยู่จัดส่งของลูกค้า</p>
                        </a>
                    </li>

                    <hr>

                    <li class="nav-item">
                        <a href="{{ route('admin.reports.sales') }}" class="nav-link active">
                            <i class="fa-solid fa-file-export"></i>
                            <p>รายงานการขายสินค้า</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.reports.top-products') }}" class="nav-link active">
                            <i class="fa-solid fa-star"></i>
                            <p>รายงานสินค้าขายดี 5 อันดับ</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>