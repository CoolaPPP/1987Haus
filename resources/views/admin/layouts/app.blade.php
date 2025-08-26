<!DOCTYPE html>
<html lang="en">

@include('admin.layouts.partials.header')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        @include('admin.layouts.partials.navbar')

        <!-- Sidebar -->
        @include('admin.layouts.partials.sidebar')

        <!-- Content Wrapper -->
        <div class="content-wrapper" style="background:#f8f3d9;">
            <div class="content-header">
                <div class="container-fluid">
                    <h1 class="m-0">@yield('content-header', 'Dashboard')</h1>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

        <!-- Footer -->
        @include('admin.layouts.partials.footer')
    </div>

    <!-- Scripts -->
    @include('admin.layouts.partials.scripts')
</body>
</html>
