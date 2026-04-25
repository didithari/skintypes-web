<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkinAI - Kenali Jenis Kulit Wajahmu</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Navigation */
        nav {
            background: transparent;
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        nav.scrolled {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
            padding: 0.8rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        nav .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: #A8C5B8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        nav a {
            text-decoration: none;
            color: #333;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #A8C5B8;
        }

        .hamburger {
            display: none;
            cursor: pointer;
            width: 28px;
            height: 28px;
            color: #333;
        }

        .mobile-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            z-index: 2000;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .mobile-menu-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .mobile-menu-close {
            position: absolute;
            top: 25px;
            right: 25px;
            cursor: pointer;
            width: 32px;
            height: 32px;
            color: #333;
        }

        .mobile-nav-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 30px;
            text-align: center;
        }

        .mobile-nav-links a {
            text-decoration: none;
            color: #333;
            font-size: 1.5rem;
            font-weight: 600;
        }

        /* Hero Section */
        .hero {
            background: #FAFAFA;
            padding: 90px 0 100px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: #FDF5F6;
            border-radius: 50%;
            bottom: -150px;
            left: -100px;
            z-index: 0;
        }

        .hero::after {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: #F2F5F5;
            border-radius: 50%;
            top: 0px;
            right: -100px;
            z-index: 0;
        }

        .hero .container {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .hero-badge-top {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 25px;
            font-weight: 500;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }

        .hero-content h1 {
            font-size: 3.5rem;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: #1A1A2E;
        }

        .hero-content .highlight {
            color: #A8C5B8;
        }

        .hero-content p {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 2.5rem;
            line-height: 1.6;
            max-width: 90%;
        }

        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2rem;
            align-items: center;
        }

        .btn-primary {
            background: #A8C5B8;
            color: white;
            padding: 15px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-primary:hover {
            background: #8fb3a1;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(168, 197, 184, 0.4);
        }

        .btn-demo {
            background: white;
            color: #333;
            padding: 8px 25px 8px 8px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .btn-demo:hover {
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            transform: translateY(-2px);
        }

        .play-icon {
            width: 36px;
            height: 36px;
            background: #E8F4F0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #A8C5B8;
        }

        .play-icon svg {
            width: 14px;
            height: 14px;
            margin-left: 2px;
        }

        .hero-badge-bottom {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: 0.95rem;
        }

        .hero-badge-bottom .shield {
            width: 20px;
            height: 20px;
        }

        .hero-image {
            background: white;
            padding: 20px;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
            max-width: 480px;
            margin-left: auto;
            position: relative;
            z-index: 2;
        }

        .image-wrapper {
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .image-wrapper img {
            width: 100%;
            height: 460px;
            object-fit: cover;
            display: block;
        }

        .image-footer {
            height: 60px;
            background: #E8F4F0;
            width: 100%;
        }

        /* Steps Section */
        .steps {
            padding: 100px 0;
            background: white;
            text-align: center;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-badge {
            display: inline-block;
            background: #F8F9FA;
            padding: 6px 16px;
            border-radius: 20px;
            color: #A8C5B8;
            font-weight: 500;
            margin-bottom: 1rem;
            font-size: 0.85rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #1A1A2E;
        }

        .section-title p {
            color: #666;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 3rem;
            margin-top: 4rem;
        }

        .step-card {
            background: #F9FBFB;
            border-radius: 24px;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .step-number {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 36px;
            height: 36px;
            background: #A8C5B8;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
            opacity: 0.4;
        }

        .step-icon {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: #A8C5B8;
        }

        .step-card h3 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: #1A1A2E;
        }

        .step-card p {
            color: #666;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        /* Features Section */
        .features {
            padding: 100px 0;
            background: #FDFBFB;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            margin-top: 4rem;
        }

        .feature-card {
            background: white;
            padding: 2.5rem;
            border-radius: 24px;
            display: flex;
            gap: 1.5rem;
            align-items: flex-start;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #F0F0F0;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: #E8F4F0;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.8rem;
        }

        .feature-icon.pink {
            background: #FCE8EC;
        }

        .feature-content h3 {
            font-size: 1.3rem;
            margin-bottom: 0.8rem;
            color: #1A1A2E;
        }

        .feature-content p {
            color: #666;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        /* CTA Section */
        .cta {
            padding: 100px 0;
            background: #C5D8C8;
            text-align: center;
            position: relative;
            overflow: hidden;
            color: white;
        }

        .cta::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -150px;
            left: -100px;
            z-index: 0;
        }

        .cta::after {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            bottom: -200px;
            right: -100px;
            z-index: 0;
        }

        .cta .container {
            position: relative;
            z-index: 1;
        }

        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: white;
        }

        .cta p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2.5rem;
        }

        .btn-white {
            background: white;
            color: #A8C5B8;
            padding: 15px 35px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: transform 0.3s;
        }

        .btn-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        /* Footer */
        footer {
            background: #1a1a2e;
            color: #fff;
            padding: 60px 0 30px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr auto;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .footer-brand .logo-icon {
            background: #A8C5B8;
        }

        .footer-about p {
            color: #aaa;
            line-height: 1.8;
        }

        .footer-section h4 {
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.8rem;
        }

        .footer-section a {
            color: #aaa;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section a:hover {
            color: #A8C5B8;
        }

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-link {
            width: 40px;
            height: 40px;
            background: #2a2a3e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-decoration: none;
            transition: background 0.3s;
        }

        .social-link:hover {
            background: #A8C5B8;
        }

        .footer-bottom {
            border-top: 1px solid #2a2a3e;
            padding-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #aaa;
            font-size: 0.9rem;
        }

        .footer-bottom-links {
            display: flex;
            gap: 2rem;
        }

        .footer-bottom-links a {
            color: #aaa;
            text-decoration: none;
        }

        .footer-bottom-links a:hover {
            color: #A8C5B8;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .container {
                padding: 0 15px;
            }

            .hero {
                padding: 120px 0 60px;
            }

            .hero .container {
                gap: 40px;
            }

            .hero-content h1 {
                font-size: 2.5rem;
            }

            .hero-image {
                padding: 30px;
            }
        }

        @media (max-width: 768px) {
            nav {
                padding: 15px 0;
            }

            .hamburger {
                display: block;
            }

            .logo {
                font-size: 1.2rem;
            }

            .logo-icon {
                width: 35px;
                height: 35px;
            }

            nav ul {
                display: none;
            }

            .hero {
                padding: 120px 0 80px;
            }

            .hero::before {
                width: 100%;
                height: 100%;
                border-radius: 0;
                bottom: 0;
                left: 0;
                background: rgba(255, 255, 255, 0.45);
                z-index: 1;
            }

            .hero::after {
                display: none;
            }

            .hero .container {
                position: static;
                grid-template-columns: 1fr;
                gap: 30px;
                z-index: auto;
            }

            .hero-content {
                position: relative;
                z-index: 2;
                text-align: center;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .hero-content h1 {
                font-size: 1.75rem;
                line-height: 1.3;
            }

            .hero-content p {
                font-size: 1rem;
                text-align: center;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .btn {
                padding: 12px 30px;
                font-size: 0.95rem;
                width: 100%;
            }

            .hero-image {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                max-width: 100%;
                margin: 0;
                padding: 0;
                background: transparent;
                box-shadow: none;
                border-radius: 0;
                z-index: 0;
            }

            .image-wrapper {
                height: 100%;
                border-radius: 0;
            }

            .image-wrapper img {
                height: 100%;
                border-radius: 0;
            }

            .image-footer {
                display: none;
            }

            .section-title {
                margin-bottom: 30px;
            }

            .section-title h2 {
                font-size: 1.8rem;
            }

            .section-title p {
                font-size: 0.95rem;
            }

            .steps {
                padding: 50px 0;
            }

            .steps-grid {
                display: flex;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                gap: 15px;
                padding-bottom: 20px;
                margin: 0 -15px;
                padding: 0 15px 20px 15px;
                scrollbar-width: none;
                -ms-overflow-style: none;
            }

            .steps-grid::-webkit-scrollbar {
                display: none;
            }

            .step-card {
                flex: 0 0 85%;
                scroll-snap-align: center;
            }

            .step-card h3 {
                font-size: 1.1rem;
            }

            .step-card p {
                font-size: 0.9rem;
            }

            .features {
                padding: 50px 0;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .feature-card {
                padding: 1.5rem;
            }

            .feature-icon {
                width: 50px;
                height: 50px;
                font-size: 1.5rem;
            }

            .feature-content h3 {
                font-size: 1.1rem;
            }

            .cta {
                padding: 50px 0;
            }

            .cta h2 {
                font-size: 1.8rem;
            }

            .cta p {
                font-size: 0.95rem;
            }

            .stats {
                flex-direction: column;
                gap: 1.5rem;
            }

            .stat-value {
                font-size: 2rem;
            }

            .stat-label {
                font-size: 0.9rem;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 2rem;
                margin-bottom: 2rem;
            }

            .footer-bottom {
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 12px;
            }

            nav {
                padding: 12px 0;
            }

            .logo {
                font-size: 1rem;
            }

            .logo-icon {
                width: 32px;
                height: 32px;
                font-size: 0.9rem;
            }

            .hero {
                padding: 90px 0 30px;
            }

            .hero-content h1 {
                font-size: 1.5rem;
                margin-bottom: 0.8rem;
            }

            .hero-content p {
                font-size: 0.9rem;
                margin-bottom: 1.5rem;
            }

            .hero-buttons {
                flex-direction: column;
                gap: 10px;
                margin-bottom: 1.5rem;
            }

            .btn {
                padding: 12px 25px;
                font-size: 0.9rem;
                min-height: 44px;
            }

            .hero-badge {
                font-size: 0.85rem;
            }



            .section-title h2 {
                font-size: 1.5rem;
            }

            .section-title p {
                font-size: 0.85rem;
            }

            .steps {
                padding: 35px 0;
            }

            .steps-grid {
                gap: 15px;
            }

            .step-number {
                width: 50px;
                height: 50px;
                font-size: 1.3rem;
                margin-bottom: 1rem;
            }

            .step-icon {
                width: 60px;
                height: 60px;
                font-size: 1.8rem;
            }

            .step-card h3 {
                font-size: 1rem;
                margin-bottom: 0.6rem;
            }

            .step-card p {
                font-size: 0.85rem;
            }

            .features {
                padding: 35px 0;
            }

            .features-grid {
                gap: 1.2rem;
            }

            .feature-card {
                padding: 1.2rem;
                gap: 1rem;
            }

            .feature-icon {
                width: 45px;
                height: 45px;
                font-size: 1.3rem;
                min-width: 45px;
            }

            .feature-content h3 {
                font-size: 1rem;
                margin-bottom: 0.5rem;
            }

            .feature-content p {
                font-size: 0.85rem;
            }

            .cta {
                padding: 35px 0;
            }

            .cta h2 {
                font-size: 1.5rem;
            }

            .cta p {
                font-size: 0.85rem;
                margin-bottom: 1.5rem;
            }

            .cta .btn {
                min-height: 44px;
            }

            .stats {
                gap: 1.2rem;
            }

            .stat-value {
                font-size: 1.8rem;
            }

            footer {
                padding: 40px 0 20px;
            }

            .footer-about p {
                font-size: 0.85rem;
            }

            .footer-section h4 {
                font-size: 1rem;
                margin-bottom: 1rem;
            }

            .footer-section ul li {
                margin-bottom: 0.6rem;
            }

            .footer-section a {
                font-size: 0.85rem;
            }

            .social-links {
                gap: 0.8rem;
            }

            .social-link {
                width: 36px;
                height: 36px;
            }

            .footer-bottom {
                font-size: 0.8rem;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="container">
            <div class="logo">
                <div class="logo-icon">S</div>
                <span>SkinAI</span>
            </div>
            <div class="hamburger" id="hamburger-menu">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </div>
            <ul>
                <li><a href="#beranda">Beranda</a></li>
                <li><a href="#cara-kerja">Cara Kerja</a></li>
                <li><a href="#tentang">Tentang</a></li>
                <li><a href="#kontak">Kontak</a></li>
            </ul>
        </div>
    </nav>

    <div class="mobile-menu-overlay" id="mobile-menu">
        <div class="mobile-menu-close" id="mobile-menu-close">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </div>
        <ul class="mobile-nav-links">
            <li><a href="#beranda" class="mobile-link">Beranda</a></li>
            <li><a href="#cara-kerja" class="mobile-link">Cara Kerja</a></li>
            <li><a href="#tentang" class="mobile-link">Tentang</a></li>
            <li><a href="#kontak" class="mobile-link">Kontak</a></li>
        </ul>
    </div>

    <!-- Hero Section -->
    <section class="hero" id="beranda">
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge-top">
                    ✨ AI-Powered Skincare Analysis
                </div>
                <h1>Kenali Jenis<br><span class="highlight">Kulit Wajahmu</span></h1>
                <p>Analisis wajahmu dengan teknologi AI canggih untuk mendapatkan rekomendasi produk skincare yang tepat dan personal sesuai jenis kulitmu.</p>
                <div class="hero-buttons">
                    <a href="{{ route('scanner') }}" class="btn-primary">
                        Coba Sekarang ➔
                    </a>
                    <a href="#" class="btn-demo">
                        <div class="play-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                        Lihat Demo
                    </a>
                </div>
                <div class="hero-badge-bottom">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#A8C5B8" stroke-width="2" class="shield">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    <span>100% Aman & Private</span>
                </div>
            </div>
            <div class="hero-image">
                <div class="image-wrapper">
                    <img src="https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?w=500&h=600&fit=crop" alt="Woman touching face">
                    <div class="image-footer"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Steps Section -->
    <section class="steps" id="cara-kerja">
        <div class="container">
            <div class="section-title">
                <div class="section-badge">✦ Cara Kerja</div>
                <h2>Mudah & Cepat dalam 3 Langkah</h2>
                <p>Dapatkan analisis kulit wajah yang akurat dan rekomendasi produk yang tepat hanya dalam hitungan detik</p>
            </div>
            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div class="step-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#A8C5B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                            <circle cx="12" cy="13" r="4"></circle>
                        </svg>
                    </div>
                    <h3>Foto Wajah</h3>
                    <p>Ambil foto wajahmu dengan pencahayaan yang baik atau upload foto yang sudah ada</p>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div class="step-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#A8C5B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect>
                            <rect x="9" y="9" width="6" height="6"></rect>
                            <line x1="9" y1="1" x2="9" y2="4"></line>
                            <line x1="15" y1="1" x2="15" y2="4"></line>
                            <line x1="9" y1="20" x2="9" y2="23"></line>
                            <line x1="15" y1="20" x2="15" y2="23"></line>
                            <line x1="20" y1="9" x2="23" y2="9"></line>
                            <line x1="20" y1="14" x2="23" y2="14"></line>
                            <line x1="1" y1="9" x2="4" y2="9"></line>
                            <line x1="1" y1="14" x2="4" y2="14"></line>
                        </svg>
                    </div>
                    <h3>Analisis AI</h3>
                    <p>Teknologi AI kami akan menganalisis jenis kulit, kondisi, dan kebutuhan perawatanmu</p>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div class="step-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#A8C5B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="7" y="10" width="10" height="12" rx="2"></rect>
                            <path d="M12 10V6"></path>
                            <path d="M12 6H9"></path>
                            <path d="M10 3h4"></path>
                            <path d="M18 5v1m-.5-.5h1"></path>
                            <path d="M20 9v1m-.5-.5h1"></path>
                        </svg>
                    </div>
                    <h3>Rekomendasi Skincare</h3>
                    <p>Dapatkan rekomendasi produk skincare yang tepat dan personal untuk kulitmu</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="tentang">
        <div class="container">
            <div class="section-title">
                <h2>Mengapa Memilih SkinAI?</h2>
                <p>Teknologi terdepan untuk analisis kulit yang akurat dan rekomendasi yang personal</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#A8C5B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m21.64 3.64-1.28-1.28a1.21 1.21 0 0 0-1.72 0L2.36 18.64a1.21 1.21 0 0 0 0 1.72l1.28 1.28a1.2 1.2 0 0 0 1.72 0L21.64 5.36a1.2 1.2 0 0 0 0-1.72Z"/>
                            <path d="m14 7 3 3"/>
                            <path d="M5 6v4"/>
                            <path d="M19 14v4"/>
                            <path d="M10 2v2"/>
                            <path d="M7 8H3"/>
                            <path d="M21 16h-4"/>
                            <path d="M11 3H9"/>
                        </svg>
                    </div>
                    <div class="feature-content">
                        <h3>AI Teknologi Terkini</h3>
                        <p>Menggunakan machine learning dan deep learning untuk analisis yang presisi dan akurat</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon pink">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#D28F9E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M22 11c0 4.5-3 8-5 10-2-2-5-5.5-5-10V7l5-2 5 2Z"/>
                        </svg>
                    </div>
                    <div class="feature-content">
                        <h3>Privasi Terjamin</h3>
                        <p>Data dan foto wajahmu aman, tidak disimpan, dan hanya digunakan untuk analisis</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#A8C5B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <div class="feature-content">
                        <h3>Hasil Instan</h3>
                        <p>Dapatkan hasil analisis dan rekomendasi hanya dalam hitungan detik</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon pink">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#D28F9E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                        </svg>
                    </div>
                    <div class="feature-content">
                        <h3>Rekomendasi Personal</h3>
                        <p>Produk skincare yang direkomendasikan sesuai dengan kondisi kulit unikmu</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Siap Menemukan Skincare yang Tepat?</h2>
            <p>Mulai perjalanan skincare-mu sekarang dan dapatkan kulit sehat yang kamu impikan</p>
            <a href="{{ route('scanner') }}" class="btn-white">Coba Sekarang Gratis ➔</a>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak">
        <div class="container">
            <div class="footer-content">
                <div class="footer-about">
                    <div class="footer-brand">
                        <div class="logo-icon">S</div>
                        <span>SkinAI</span>
                    </div>
                    <p>Solusi cerdas untuk menemukan skincare yang tepat dan personal menggunakan AI.</p>
                </div>
                <div class="footer-section">
                    <h4>Produk</h4>
                    <ul>
                        <li><a href="#">Analisis Kulit</a></li>
                        <li><a href="#">Rekomendasi</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4>Ikuti Kami</h4>
                    <div class="social-links">
                        <a href="#" class="social-link">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                                <circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                                <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                                <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                                <path d="M9 12a1 1 0 11-2 0 1 1 0 012 0zm1 0a1 1 0 11 2 0 1 1 0 01-2 0zm5 0a1 1 0 11 2 0 1 1 0 01-2 0z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div>© 2025 SkinAI. All rights reserved.</div>
                <div class="footer-bottom-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
    <script>
        // Mobile Menu Toggle
        const hamburger = document.getElementById('hamburger-menu');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMenu = document.getElementById('mobile-menu-close');
        const mobileLinks = document.querySelectorAll('.mobile-link');

        if (hamburger) {
            hamburger.addEventListener('click', () => {
                mobileMenu.classList.add('active');
            });
        }

        if (closeMenu) {
            closeMenu.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
            });
        }

        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
            });
        });

        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
