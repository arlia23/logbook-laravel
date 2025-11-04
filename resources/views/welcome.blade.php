<!DOCTYPE html>
<html lang="id" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Logbook Digital - Sistem Absensi & Kegiatan Modern</title>
    <meta name="description"
        content="Sistem logbook digital untuk pencatatan absensi dan kegiatan harian yang mudah dan efisien" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/2.44.0/tabler-icons.min.css" />

    <style>
        :root {
            --bs-primary: #696cff;
            --bs-primary-rgb: 105, 108, 255;
            --bs-secondary: #8592a3;
            --bs-success: #c737dd;
            --bs-info: #03c3ec;
            --bs-warning: #ffab00;
            --bs-danger: #ff3e1d;
            --bs-light: #fcfdfd;
            --bs-dark: #233446;
            --bs-gray: #8592a3;
            --bs-gray-dark: #566a7f;
            --bs-gray-100: #f8f9fa;
            --bs-gray-200: #ebeef0;
            --bs-gray-300: #d7dee3;
            --bs-gray-400: #c3cdd7;
            --bs-gray-500: #aeb7c0;
            --bs-gray-600: #8a8d93;
            --bs-gray-700: #566a7f;
            --bs-gray-800: #435971;
            --bs-gray-900: #384551;
            --bs-white: #fff;
            --bs-black: #000;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Public Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f5f5f9;
            color: #566a7f;
            line-height: 1.53;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* Header Navigation */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            z-index: 1050;
            padding: 1rem 0;
            box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 2px 20px rgba(67, 89, 113, 0.15);
            padding: 0.5rem 0;
        }

        .navbar-container {
            max-width: 1440px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 1.5rem;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--bs-dark);
            font-weight: 700;
            font-size: 1.375rem;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .navbar-brand i {
            color: var(--bs-primary);
            margin-right: 0.5rem;
            font-size: 1.5rem;
        }

        .navbar-nav {
            display: flex;
            list-style: none;
            gap: 2rem;
            align-items: center;
        }

        .navbar-nav a {
            text-decoration: none;
            color: var(--bs-gray-700);
            font-weight: 500;
            position: relative;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
        }

        .navbar-nav a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: var(--bs-primary);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .navbar-nav a:hover {
            color: var(--bs-primary);
            background: rgba(105, 108, 255, 0.04);
        }

        .navbar-nav a:hover::after {
            width: 80%;
        }

        .auth-buttons {
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }

        /* Auth buttons styling sesuai format Laravel */
        .auth-buttons a {
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
            color: #000;
            border: 1px solid transparent;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .auth-buttons a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s;
        }

        .auth-buttons a:hover::before {
            left: 100%;
        }

        .auth-buttons a:hover {
            color: rgba(0, 0, 0, 0.7);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .auth-buttons a:focus {
            outline: none;
        }

        .auth-buttons a:focus-visible {
            outline: 2px solid #FF2D20;
        }

        /* Dark theme support for auth buttons */
        @media (prefers-color-scheme: dark) {
            .auth-buttons a {
                color: white;
            }

            .auth-buttons a:hover {
                color: rgba(255, 255, 255, 0.8);
            }

            .auth-buttons a:focus-visible {
                outline-color: white;
            }
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--bs-primary) 0%, #8b5cf6 50%, var(--bs-success) 100%);
            position: relative;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.08)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
        }

        .hero-container {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 1.5rem;
            position: relative;
            z-index: 2;
        }

        .hero-content {
            max-width: 600px;
            color: white;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .hero-badge i {
            margin-right: 0.5rem;
            color: #fbbf24;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .hero p {
            font-size: 1.25rem;
            line-height: 1.7;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 500;
            line-height: 1.53;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            user-select: none;
            border: 1px solid transparent;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        .btn:hover::after {
            animation: ripple 1s ease-out;
        }

        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }

            100% {
                transform: scale(20, 20);
                opacity: 0;
            }
        }

        .btn-white {
            background: white;
            color: var(--bs-dark);
            border: none;
        }

        .btn-white:hover {
            background: #f8f9fa;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-outline-white {
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            background: transparent;
        }

        .btn-outline-white:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-3px);
        }

        /* Stats Section */
        .stats {
            background: white;
            margin-top: -80px;
            position: relative;
            z-index: 10;
            border-radius: 1rem;
            box-shadow: 0 10px 40px rgba(67, 89, 113, 0.12);
            padding: 2.5rem 1.5rem;
            max-width: 1140px;
            margin-left: auto;
            margin-right: auto;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat-item {
            padding: 1rem;
            transition: transform 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--bs-primary), #8b5cf6);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            color: white;
            transition: all 0.3s ease;
        }

        .stat-item:hover .stat-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--bs-dark);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--bs-gray-700);
            font-weight: 500;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar-nav {
                display: none;
            }

            .hero h1 {
                font-size: 2.5rem;
            }


            .stats {
                margin-top: -40px;
                padding: 2rem 1rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .scroll-to-top {
                bottom: 1rem;
                right: 1rem;
            }
        }

        /* Animations */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Particle background for hero section */
        .particles-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            animation: float-particle 15s infinite linear;
        }

        @keyframes float-particle {
            0% {
                transform: translateY(0) translateX(0) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-100vh) translateX(100px) rotate(360deg);
                opacity: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="navbar-container">
            <a href="#" class="navbar-brand">
                <i class="ti ti-clipboard-check"></i>
                LogBook Perpustakaan
            </a>

            <ul class="navbar-nav">
                <li><a href="#home">Beranda</a></li>
                <li><a href="#Statistics ">Statistics </a></li>
                <li><a href="#footer">Footer</a></li>
            </ul>

            <!-- Auth buttons sesuai format Laravel Anda -->
            <div class="auth-buttons">
                <a href="{{ route('login') }}"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                    Log in
                </a>

                <a href="{{ route('register') }}"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                    Register
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="particles-container" id="particles"></div>
        <div class="floating-shapes">
            <i class="ti ti-clock shape shape-1"></i>
            <i class="ti ti-calendar shape shape-2"></i>
            <i class="ti ti-clipboard-list shape shape-3"></i>
            <i class="ti ti-chart-bar shape shape-4"></i>
            <i class="ti ti-bell shape shape-5"></i>
        </div>

        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-badge">
                    <i class="ti ti-check-circle"></i>
                    Sistem Absensi & Kegiatan Terpercaya
                </div>

                <h1 class="fade-in-up">LogBook Digital untuk Absensi & Kegiatan Harian</h1>

                <p class="fade-in-up" style="animation-delay: 0.2s;">
                    Kelola absensi karyawan dan catat kegiatan harian dengan mudah.
                    Sistem logbook modern yang memudahkan pencatatan waktu kerja dan aktivitas tim.
                </p>


            </div>
        </div>
    </section>

    <!-- Statistics -->
   <div class="stats" id="Statistics">
    <div class="stats-grid">
        <div class="stat-item">
            <div class="stat-icon">
                <img style="width: 75px" src="{{ asset('template/img/icons/orang.png') }}" alt="Orang" />
            </div>
            <div class="stat-number">{{ $jumlahKaryawan }}</div>
            <div class="stat-label">Jumlah Karyawan</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <img style="width: 75px" src="{{ asset('template/img/icons/logbook.png') }}" alt="Logbook" />
            </div>
            <div class="stat-number">{{ $jumlahLogbook }}</div>
            <div class="stat-label">Pengisian Logbook</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <img style="width: 75px" src="{{ asset('template/img/icons/hadir.png') }}" alt="Hadir" />
            </div>
            <div class="stat-number">{{ $jumlahHadirHariIni }}</div>
            <div class="stat-label">Kehadiran Hari Ini</div>
        </div>
    </div>
</div>

    <!-- Footer -->
   
   <footer id="footer" style="text-align: center; margin-top: 30px; margin-bottom: 20px; padding-top: 10px; padding-bottom: 10px;">
    <div>
        <p>&copy; 2025 LogBook UPT Perpustakaan UNRI</p>
    </div>
</footer>


    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            const scrollToTop = document.getElementById('scrollToTop');

            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }

            // Show/hide scroll to top button
            if (window.scrollY > 300) {
                scrollToTop.classList.add('show');
            } else {
                scrollToTop.classList.remove('show');
            }
        });

        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Animated counters
        function animateCounter(element) {
            const target = parseInt(element.getAttribute('data-count'));
            const increment = target / 100;
            let current = 0;

            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                element.textContent = Math.floor(current).toLocaleString();
            }, 20);
        }

        // Particle effect for hero section
        function createParticles() {
            const container = document.getElementById('particles');
            const particleCount = 30;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');

                // Random size
                const size = Math.random() * 5 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;

                // Random position
                particle.style.left = `${Math.random() * 100}%`;
                particle.style.top = `${Math.random() * 100}%`;

                // Random animation duration
                const duration = Math.random() * 20 + 10;
                particle.style.animationDuration = `${duration}s`;

                // Random delay
                particle.style.animationDelay = `${Math.random() * 5}s`;

                container.appendChild(particle);
            }
        }

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Animate counters
                    if (entry.target.classList.contains('stats')) {
                        const counters = entry.target.querySelectorAll('[data-count]');
                        counters.forEach(counter => animateCounter(counter));
                    }

                    // Add fade-in animations to feature cards
                    const elements = entry.target.querySelectorAll('.feature-card');
                    elements.forEach((element, index) => {
                        setTimeout(() => {
                            element.style.opacity = '1';
                            element.style.transform = 'translateY(0)';
                        }, index * 100);
                    });

                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Create particles
            createParticles();

            // Observe elements
            observer.observe(document.querySelector('.stats'));
            observer.observe(document.querySelector('.features'));

            // Initialize feature cards animation
            document.querySelectorAll('.feature-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            });
        });

        // Add ripple effect to buttons
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const ripple = document.createElement('span');
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                ripple.classList.add('ripple-effect');

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    </script>
</body>

</html>
