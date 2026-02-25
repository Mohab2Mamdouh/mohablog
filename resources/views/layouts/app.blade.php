<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - {{ $title }}</title>

    <link rel="icon" href="{{ URL('storage/favicon.png') }}" type="image/icon type">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/Admin/script.js') }}" defer></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="{{ URL::asset('css/all.min.css') }}">

    <!-- Styles -->
    <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/guest.css') }}" rel="stylesheet">
    
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: #0f172a;
            display: flex;
            flex-direction: column;
        }
        
        .content {
            flex: 1 0 auto;
        }
        
        footer {
            flex-shrink: 0;
        }
        
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--ramadan-green), var(--ramadan-gold));
            transform: scaleX(0);
            transform-origin: left;
            z-index: 99999;
        }
        
        body.loading .page-loader {
            animation: loadProgress 1s ease-in-out;
        }
        
        @keyframes loadProgress {
            0% { transform: scaleX(0); }
            50% { transform: scaleX(0.7); }
            100% { transform: scaleX(1); }
        }
    </style>

    {{-- Scripts --}}
    <script src="{{ URL::asset('js/jquery-3.6.0.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css"></script>

</head>
<body>
    <div class="page-loader"></div>

    <section class="content">
        @yield('content')
    </section>

    <footer>
        @include('layouts.footer')
    </footer>



    {{-- Font Awesome --}}
    <script src="{{ URL::asset('js/all.min.js') }}"></script>

    {{-- Script --}}
    <script src="{{ URL::asset('js/Admin/sidebar.js') }}"></script>
    <script src="{{ URL::asset('js/Admin/script.js') }}"></script>
    
    <script>
        // Page load animation
        document.body.classList.add('loading');
        window.addEventListener('load', () => {
            setTimeout(() => document.body.classList.remove('loading'), 300);
        });
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if(target) target.scrollIntoView({ behavior: 'smooth' });
            });
        });
        
        // Add intersection observer for scroll animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });
        
        document.querySelectorAll('.section-content').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>
