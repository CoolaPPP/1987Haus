<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=KoHo:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons & CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    @yield('styles')

    <style>
        body {
    font-family: 'KoHo', sans-serif;
    }

    .main-header {
        background-color: #504b38 !important;
        color: #f8f3d9 !important;
    }
    
    .main-sidebar {
        background-color: #b9b28a !important;
    }

    .sidebar {
        background-color: #ebe5c2 !important;
    }

    .nav-link.active {
        background-color: #f8f3d9 !important;
        color: #504b38 !important;
    }
    .cart-table thead {
        background-color: #504b38;
        color: #f8f3d9;
    }
    </style>

</head>