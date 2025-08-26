<!-- Navigation Bar -->
<nav class="navbar navbar-expand-md sticky-top border-bottom animated-navbar" 
     style="background-color: #504B38;" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand fw-bold text-light" href="/" style="letter-spacing: 1px;">
            1987 Haus
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" 
                data-bs-target="#offcanvas" aria-controls="offcanvas" 
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel" style="background-color: #504B38;">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title text-light" id="offcanvasLabel">1987 Haus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-animated" href="{{ route('shop.index') }}">สินค้า</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-animated" href="{{ route('shop.recommended') }}">สินค้าแนะนำ</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link position-relative cart-link" href="{{ route('cart.index') }}">
                                <svg class="bi" width="24" height="24" fill="currentColor">
                                    <use xlink:href="#cart3"></use>
                                </svg>
                                @if(session('cart') && count(session('cart')) > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger mt-1 cart-badge">
                                        {{ array_sum(array_column(session('cart'), 'quantity')) }}
                                        <span class="visually-hidden">items in cart</span>
                                    </span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle nav-animated" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('customer.dashboard') }}">ข้อมูลส่วนตัว</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        ออกจากระบบ
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else 
                        <li class="nav-item">
                            <a class="nav-link nav-animated" href="{{ route('register') }}">ลงทะเบียน</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-animated" href="{{ route('login') }}">เข้าสู่ระบบ</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</nav>

<style>
/* Slide down animation on page load */
/* .animated-navbar {
    animation: slideDown 0.8s ease forwards, fadeIn 1s ease;
    opacity: 0;
}
@keyframes slideDown {
    from { transform: translateY(-60px); }
    to { transform: translateY(0); }
}
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
} */

/* Menu link hover effect */
.nav-animated {
    position: relative;
    transition: color 0.3s ease;
}
.nav-animated::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 2px;
    background-color: #E4DCCF;
    transition: all 0.3s ease;
}
.nav-animated:hover::after {
    left: 0;
    width: 100%;
}
.nav-animated:hover {
    color: #E4DCCF !important;
}

/* Cart badge bounce animation */
.cart-link:hover .cart-badge {
    animation: bounce 0.6s ease;
}
@keyframes bounce {
    0%, 100% { transform: translate(-50%, 0); }
    50% { transform: translate(-50%, -6px); }
}
</style>
