<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
    
@include('layouts.partials.header')
    <body>
        @include('layouts.partials.navbar')

            <!-- Main Content -->
            @yield('content')
    
        @include('layouts.partials.footer')
    
        @include('layouts.partials.scripts')


        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="cart3" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.49.402H3.31l.447 2.134A.5.5 0 0 1 3.5 11H13a.5.5 0 0 1 0 1H3.5a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4H12.42l.8-4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </symbol>
            <symbol id="aperture" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="m14.31 8 5.74 9.94M9.69 8h11.48M7.38 12l5.74-9.94M9.69 16 3.95 6.06M14.31 16H2.83m13.79-4-5.74 9.94"></path>
            </symbol>
        </svg>
    </body>
</html>