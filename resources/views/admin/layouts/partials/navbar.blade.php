<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Sidebar toggle button-->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-light" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- Right navbar -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link text-light" href="{{ route('admin.logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> ออกจากระบบ
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</nav>