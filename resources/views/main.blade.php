@extends('layouts.app')

@section('title', '1987 Haus | Homepage')

@section('content')
<!-- Main Content -->
<main>
    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center hero-section"
         style="background-image: url('{{ asset('images/shop.jpg') }}');
                background-size: cover;
                background-position: center;
                min-height: 600px;
                border-radius: 32px;
                display: flex;
                align-items: center;
                justify-content: center;">

        <!-- Overlay -->
        <div class="overlay"></div>

        <!-- Content Box -->
        <div class="col-md-8 p-lg-5 mx-auto text-center position-relative hero-content">
            <h1 class="display-3 fw-bold mb-4 animate-title">
                ยินดีต้อนรับสู่ <span style="color: #ebe5c2;">1987 Haus</span>
            </h1>
            <h3 class="fw-normal mb-4 animate-subtitle" style="color: #ebe5c2;">
                พร้อมให้สั่งซื้อผ่านหน้าจอของคุณแล้ว!
            </h3>

            <!-- CTA Buttons -->
            <div class="d-flex gap-3 justify-content-center animate-buttons">
                <a href="{{ route('shop.index') }}"
                   class="btn btn-lg px-4 btn-main"
                   onmouseover="this.classList.add('shake');"
                   onmouseout="this.classList.remove('shake');">
                   เมนูสินค้า
                </a>
                <a href="{{ route('about-us') }}"
                   class="btn btn-lg px-4 btn-outline"
                   onmouseover="this.classList.add('shake');"
                   onmouseout="this.classList.remove('shake');">
                   เกี่ยวกับเรา
                </a>
            </div>
        </div>
    </div>
</main>

<!-- Animation Styles -->
<style>
/* Overlay */
.overlay {
    position: absolute;
    top:0; left:0;
    width:100%; height:100%;
    background-color: rgba(80, 75, 56, 0.6);
    border-radius: 32px;
}

/* Background zoom animation */
.hero-section {
    animation: bgZoom 20s ease-in-out infinite alternate;
}

/* Text animations */
.animate-title {
    animation: fadeInUp 1.2s ease forwards;
}
.animate-subtitle {
    animation: fadeInUp 1.6s ease forwards;
}
.animate-buttons {
    animation: fadeInUp 2s ease forwards;
}

/* Button styles */
.btn-main {
    background-color: #b9b28a;
    color: #504b38;
    border-radius: 50px;
    font-weight: bold;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    transition: all 0.3s;
}
.btn-main:hover {
    background-color: #ebe5c2;
}

.btn-outline {
    background-color: transparent;
    border: 2px solid #f8f3d9;
    color: #f8f3d9;
    border-radius: 50px;
    font-weight: bold;
    transition: all 0.3s;
}
.btn-outline:hover {
    background-color: #f8f3d9;
    color: #504b38;
}

/* Shake animation for hover */
.shake {
    animation: shake 0.4s ease;
}

/* Keyframes */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes shake {
    0% { transform: translateX(0); }
    25% { transform: translateX(-4px); }
    50% { transform: translateX(4px); }
    75% { transform: translateX(-2px); }
    100% { transform: translateX(0); }
}

@keyframes bgZoom {
    from {
        background-size: 100%;
    }
    to {
        background-size: 110%;
    }
}
</style>
@endsection
